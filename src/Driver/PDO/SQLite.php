<?php

namespace DatabaseDrivers\Driver\PDO;

use DatabaseDrivers\Exceptions\DriverExtensionNotFoundException;
use DatabaseDrivers\Exceptions\SQLiteDatabaseNotExists;

class SQLite extends ConnectorObject
{
    /**
     * @param array $config
     * @return \PDO
     * @throws SQLiteDatabaseNotExists|DriverExtensionNotFoundException
     */
    public function connect(array $config)
    {
        $this->extensionControl($this->getName());

        $options = $this->getOptions($config);

        if ($config['database'] === ':memory:') {
            return $this->createConnection('sqlite::memory:', $config, $options);
        }

        $path = realpath($config['database']);

        if ($path === false) {
            throw new SQLiteDatabaseNotExists("Database ({$config['database']}) does not exists");
        }

        return $this->createConnection("sqlite:{$path}", $config, $options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pdo_sqlite';
    }


}
