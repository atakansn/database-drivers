<?php

namespace DatabaseDrivers;

use DatabaseDrivers\Driver\DriverInterface;

class Connection
{

    private array $config;

    private $driver;

    private $connection;

    private $connectionName;

    public function __construct(DriverInterface $driver,array $config,string $connectionName)
    {
        $this->config = $config;

        $this->driver = $driver;

        $this->connectionName = $connectionName;

    }

    public function isConnected()
    {
        return $this->connection !== null;
    }

    public function connect()
    {
        if($this->connection !== null) {
            return $this->connection;
        }

        try {
            $this->connection = $this->driver->connect($this->config['connections'][$this->connectionName]);
        }catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $this->connection;
    }

    public function insert(string $table, array $data, array $types = [])
    {
        if(count($data) === 0) {
            return $this->statement('INSERT INTO ' . $table . ' () VALUES ()');
        }

        $columns = $values = $set = [];

        foreach ($data as $columnName => $value) {
            $columns[] = $columnName;
            $values[] = $value;
            $set[] = '?';
        }

        return $this->statement('INSERT INTO ' . $table . ' (' . implode(', ',$columns) . ')' . ' VALUES (' . implode(', ',$set) . ')',$values);
    }

    public function statement(string $sql, array $params = [], array $types = [])
    {
        $connection = $this->connect();

        try {
            if(count($params) > 0) {
                $stmt = $connection->prepare($sql);

                if(count($types) > 0) {
                    $result = $stmt->execute();
                }else{
                    $result = $stmt->execute($params);
                }

                return $result ?: false;

            }

            return $connection->exec($sql);

        }catch (\Exception $exception) {
           echo $exception->getMessage();
        }
    }

}