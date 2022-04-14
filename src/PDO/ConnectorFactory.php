<?php

namespace DatabaseDrivers\PDO;

use Exception;
use function config;

class ConnectorFactory
{

    public function produce()
    {
        return $this->createDriver(config('database'));
    }

    private function createDriver(array $config)
    {
        if (!isset($config['default'])) {
            throw new Exception("A driver must be specified");
        }

        return match ($config['default']) {
            'mysql' => (new MySQLDriver())->connect(config('database')['connections'][$config['default']]),
            'pgsql' => (new PostgresDriver())->connect(config('database')['connections'][$config['default']]),
            'sqlite' => (new SQLiteDriver())->connect(config('database')['connections'][$config['default']]),
            //'sqlsrv' => (new SQLServerDriver())->connect(config('database')[$config['default']]),

            default => throw new \Exception("Unsupported driver {$config['default']}")
        };
    }


}