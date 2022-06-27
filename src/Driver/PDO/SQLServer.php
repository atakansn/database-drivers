<?php

namespace DatabaseDrivers\Driver\PDO;

class SQLServer extends ConnectorObject
{

    public function connect(array $config)
    {
        $this->extControl($this->getName());

        return $this->createConnection($this->getDsn($config), $config, $this->getOptions($config));
    }

    private function getDsn(array $config)
    {
        if (isset($config['odbc']) && in_array('odbc', $this->getAvailableDrivers(), true)) {
            return $this->getOdbcDsn($config);
        }

        if (in_array('sqlsrv', $this->getAvailableDrivers(), true)) {
            return $this->getSQLSrvDsn($config);
        }

        $this->getDblibDsn($config);

    }

    private function getOdbcDsn(array $config)
    {
        return $config['odbc_dsn'] ?? '';
    }

    private function getDblibDsn(array $config)
    {
        return $this->buildDsnString('dblib',
            array_merge([
                'host' => $this->buildHostWithPort($config, ':'),
                'dbname' => $config['database'],
            ],
            array_intersect_key($config, array_flip(['appname', 'charset', 'version']))
        ));
    }

    private function getSQLSrvDsn(array $config)
    {
        $dsn = [
            'Server' => $this->buildHostWithPort($config, ',')
        ];

        if (isset($config['database'])) {
            $dsn['Database'] = $config['database'];
        }

        if (isset($config['app'])) {
            $dsn['App'] = $config['app'];
        }

        if (isset($config['connection_pooling']) && $config['connection_pooling'] === false) {
            $dsn['ConnectionPooling'] = 'false';
        }

        if (isset($config['encrypt']) && $config['encrypt'] === false) {
            $dsn['Encrypt'] = 'false';
        }

        if (isset($config['failover_partner'])) {
            $dsn['Failover_Partner'] = $config['failover_partner'];
        }

        if (isset($config['login_timeout'])) {
            $dsn['LoginTimeout'] = $config['login_timeout'];
        }

        if (isset($config['multiple_active_result_sets']) && $config['multiple_active_result_sets'] === false) {
            $dsn['MultipleActiveResultSets'] = 'false';
        }

        if (isset($config['quoted_id']) && $config['quoted_id'] === false) {
            $dsn['QuotedId'] = 'false';
        }

        if (isset($config['trace_file'])) {
            $dsn['TraceFile'] = $config['trace_file'];
        }

        if (isset($config['trace_on']) && $config['trace_on'] === false) {
            $dsn['TraceOn'] = 'false';
        }

        if (isset($config['transaction_isolation'])) {
            $dsn['TransactionIsolation'] = $config['transaction_isolation'];
        }

        if (isset($config['trust_server_certificate']) && $config['trust_server_certificate'] === false) {
            $dsn['TrustServerCertificate'] = 'false';
        }

        if (isset($config['wsid'])) {
            $dsn['WSID'] = $config['wsid'];
        }

        return $this->buildDsnString('sqlsrv', $dsn);
    }

    private function buildHostWithPort(array $config, string $separator = null)
    {
        if (!empty($config['port'])) {
            return $config['host'] . $separator . $config['port'];
        }

        return $config['host'];
    }

    private function buildDsnString(string $driver, array $arguments)
    {
        return $driver . ':' . implode(';', array_map(static function ($keys) use ($arguments) {
                return sprintf('%s=%s', $keys, $arguments[$keys]);
            },
                array_keys($arguments)
            ));
    }

    public function getName()
    {
        return 'pdo_sqlsrv';
    }


}