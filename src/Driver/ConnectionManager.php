<?php

namespace DatabaseDrivers\Driver;

use DatabaseDrivers\Connection;
use DatabaseDrivers\Driver\PDO\{
    MySQL,
    PostgresSQL,
    SQLite,
    SQLServer
};
use DatabaseDrivers\Exceptions\{
    InvalidParameterException,
    UnspecifiedDriverException,
    UnsupportedDriverException
};
use Throwable;

class ConnectionManager
{
    /**
     * @param string|null $connectionName
     * @return Connection
     * @throws UnspecifiedDriverException
     */
    public static function run(string $connectionName = null)
    {
        $connection = $connectionName ?? env('DB_DRIVER', 'mysql');

        $configFile = config('database');

        $driver = self::matchDriver($connection);

        try {
            return new Connection($driver, $configFile, $connection);
        } catch (Throwable $t) {
            throw new InvalidParameterException($t->getMessage(),$t->getCode());
        }
    }

    /**
     * @param $config
     * @return MySQL|PostgresSQL|SQLite|SQLServer
     * @throws UnspecifiedDriverException
     */
    private static function matchDriver($config)
    {
        if (!isset($config)) {
            throw new UnspecifiedDriverException("A driver must be specified");
        }

        return match ($config) {
            'mysql' => new MySQL,
            'pgsql' => new PostgresSQL,
            'sqlite' => new SQLite,
            'sqlsrv' => new SQLServer,

            default => throw new UnsupportedDriverException("Unsupported driver {$config}")
        };
    }


}