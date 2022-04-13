<?php

namespace DatabaseDrivers\PDO;

class SQLiteDriver extends Connector implements DriverInterface
{
    public function connect(array $config)
    {
        $options = $this->getOptions($config);

        if($config['database'] === ':memory:') {
            return $this->createConnection('sqlite::memory:',$config,$options);
        }

        $path = realpath($config['database']);

        if ($path === false) {
            throw new \Exception("Database ({$config['database']}) does not exists");
        }

        return $this->createConnection("sqlite:{$path}",$config,$options);
    }

    public function getName()
    {
       return 'pdo_sqlite';
    }


}