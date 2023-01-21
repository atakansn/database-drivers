<?php

namespace DatabaseDrivers\Driver\PDO;

use DatabaseDrivers\Exceptions\DriverExtensionNotFoundException;

class MySQL extends ConnectorObject
{
    /**
     * @param array $config
     * @return \PDO
     * @throws DriverExtensionNotFoundException
     */
    public function connect(array $config)
    {
        $this->extensionControl($this->getName());

        $dsn = $this->getDsn($config);

        $options = $this->getOptions($config);

        return $this->createConnection($dsn, $config, $options);
    }

    /**
     * @param array $config
     * @return string
     */
    private function getDsn(array $config)
    {
        return $this->hasSocket($config)
            ? $this->getSocketDsn($config)
            : $this->getHostDsn($config);
    }

    /**
     * @param array $config
     * @return bool
     */
    protected function hasSocket(array $config)
    {
        return isset($config['unix_socket']) && !empty($config['unix_socket']);
    }

    /**
     * @param array $config
     * @return string
     */
    protected function getSocketDsn(array $config)
    {
        return "mysql:unix_socket={$config['unix_socket']};dbname={$config['database']}";
    }

    /**
     * @param array $config
     * @return string
     */
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

    /**
     * @return string
     */
    public function getName()
    {
        return 'pdo_mysql';
    }
}
