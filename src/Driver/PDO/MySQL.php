<?php

namespace DatabaseDrivers\Driver\PDO;

use DatabaseDrivers\Driver\DriverInterface;

class MySQL extends ConnectionObject implements DriverInterface
{
    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);

        $options = $this->getOptions($config);

        return $this->createConnection($dsn,$config,$options);
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
        extract($config,EXTR_SKIP);

        return isset($port)
            ? "mysql:host={$host};port={$port};dbname={$database}"
            : "mysql:host={$host};dbname={$database}";
    }

    public function getName()
    {
        return 'mysql';
    }


}