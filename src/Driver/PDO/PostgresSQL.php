<?php

namespace DatabaseDrivers\Driver\PDO;

use DatabaseDrivers\Driver\DriverInterface;

class PostgresSQL extends ConnectionObject implements DriverInterface
{

    public function connect(array $config)
    {
        return $this->createConnection($this->getDsn($config),$config,$this->getOptions($config));
    }

    protected function getDsn(array $config)
    {
        extract($config,EXTR_SKIP);

        $host = isset($host)  ? "host={$host};" : '';

        $dsn = "pgsql:{$host}dbname='{$database}'";

        if(isset($config['port'])) {
            $dsn .= ";port={$port}";
        }

        return $this->addSSLOptions($dsn,$config);
    }

    protected function addSSLOptions($dsn, array $config)
    {
        foreach (['sslmode','sslcert','sslkey','sslrootcert'] as $option) {
            if(isset($config[$option])) {
                $dsn .= ";{$option}={$config[$option]}";
            }
        }

        return $dsn;
    }

    public function getName()
    {
        return 'pdo_pgsql';
    }


}