<?php

namespace DatabaseDrivers;

use DatabaseDrivers\PDO\MySQLDriver;
use DatabaseDrivers\PDO\PostgresDriver;
use DatabaseDrivers\PDO\SQLiteDriver;
use Exception;
use function config;

class ConnectionFactory
{

    private $factory;

    public function produce()
    {
        $this->factory = $this->createDrivers(config('database'));

        return $this->factory;
    }

    public function createDrivers(array $config)
    {
        if(!isset($config['default'])) {
            throw new Exception("A driver must be specified");
        }

        return match ($config['default']) {
            'mysql' => (new MySQLDriver())->connect($config['connections']['mysql']),
            'pgsql' => (new PostgresDriver())->connect($config['connections']['pgsql']),
            'sqlite' => (new SQLiteDriver())->connect($config['connections']['sqlite']),
            //'sqlsrv' => (new SQLServerDriver())->connect($config['connections']['sqlsrv']),

            default => throw new \Exception("Unsupported driver {$config['default']}")
        };
    }


}