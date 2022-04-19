<?php

namespace DatabaseDrivers\Driver;

use DatabaseDrivers\Connection;
use DatabaseDrivers\Driver\PDO\MySQL;
use DatabaseDrivers\Driver\PDO\PostgresSQL;
use DatabaseDrivers\Driver\PDO\SQLite;
use DatabaseDrivers\Driver\PDO\SQLServer;
use Exception;

class Manager
{
    private static $configFile;


    public static function run(string $connectionName = 'mysql')
    {
        self::$configFile = config('database');

        $driver = self::matchDriver($connectionName);

        $connectionClass = Connection::class;

        try {

            return new $connectionClass($driver,self::$configFile,$connectionName);
        } catch (Exception $e) {
            echo $e->getMessage();
        }


    }

    private static function matchDriver($config)
    {
        if (!isset($config)) {
            throw new Exception("A driver must be specified");
        }

        return match ($config) {
            'mysql' => new MySQL,
            'pgsql' => new PostgresSQL,
            'sqlite' => new SQLite,
            'sqlsrv' => new SQLServer,

            default => throw new \Exception("Unsupported driver {$config}")
        };
    }


}