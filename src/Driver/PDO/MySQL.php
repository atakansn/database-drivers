<?php

namespace DatabaseDrivers\Driver\PDO;

class MySQL extends ConnectorObject
{
    public function connect(array $config)
    {
        $this->extControl($this->getName());

        $dsn = $this->getDsn($config);

        $options = $this->getOptions($config);

        return $this->createConnection($dsn, $config, $options);
    }

    private function getDsn(array $config)
    {
        return $this->hasSocket($config) ? $this->getSocketDsn($config) : $this->getHostDsn($config);
    }

    protected function hasSocket(array $config)
    {
        return isset($config['unix_socket']) && !empty($config['unix_socket']);
    }

    protected function getSocketDsn(array $config)
    {
        return "mysql:unix_socket={$config['unix_socket']};dbname={$config['database']}";
    }

    protected function getHostDsn(array $config)
    {
        $dsn = 'mysql:';

        if (isset($config['host']) && !empty($config['host'])) {
            $dsn .= 'host=' . $config['host'] . ';';
        }

        if (isset($config['database'])) {
            $dsn .= 'dbname=' . $config['database'] . ';';
        }

        if (isset($config['port'])) {
            $dsn .= 'port=' . $config['port'] . ';';
        }

        if (isset($config['charset'])) {
            $dsn .= 'charset=' . $config['charset'] . ';';
        }

        return $dsn;
    }

    public function getName()
    {
        return 'pdo_mysql';
    }


}