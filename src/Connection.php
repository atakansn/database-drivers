<?php

namespace DatabaseDrivers;

use DatabaseDrivers\Driver\DriverInterface;
use PDO;
use PDOException;
use Exception;

class Connection
{
    private array $config;

    private $driver;

    private $connection;

    private $connectionName;

    public function __construct(DriverInterface $driver, array $config, string $connectionName)
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
        if ($this->connection !== null) {
            return false;
        }

        try {
            $this->connection = $this->driver->connect($this->config['connections'][$this->connectionName]);
        } catch (Exception $e) {
            $this->close();
            throw new PDOException($e->getMessage(),$e->getCode());
        }

        return true;
    }

    public function getPdo(): PDO
    {
        $this->connect();

        return $this->connection;
    }

    public function insert(string $table, array $data)
    {
        if (empty($data)) {
            return $this->statement('INSERT INTO ' . $table . ' () VALUES ()');
        }

        $columns = $params = $set = [];

        foreach ($data as $columnName => $value) {
            $columns[] = $columnName;
            $params[] = $value;
            $set[] = '?';
        }

        return $this->statement(
            'INSERT INTO ' . $table . ' (' . implode(', ', $columns) . ')' . ' VALUES (' . implode(', ', $set) . ')',
            $params
        );
    }

    public function update(string $table, array $data, array $condition)
    {
        $columns = $values = $conditions = $set = [];

        foreach ($data as $columnName => $value) {
            $columns[] = $columnName;
            $values[] = $value;
            $set[] = $columnName . ' = ?';
        }

        $this->conditionReferance($condition, $columns, $values, $conditions);

        return $this->statement(
            'UPDATE ' . $table . ' SET ' . implode(', ', $set) . ' WHERE ' . implode(' AND ', $conditions),
            $values
        );
    }

    public function delete(string $table, array $data)
    {
        $columns = $values = $conditions = [];

        $this->conditionReferance($data, $columns, $values, $conditions);

        return $this->statement(
            'DELETE FROM ' . $table . ' WHERE ' . implode(' AND ', $conditions),
            $values
        );
    }

    private function conditionReferance(array $criteria, array &$columns, array &$values, array &$conditions)
    {
        foreach ($criteria as $key => $value) {
            if ($value === null) {
                $conditions[] = $key . ' IS NULL';
                continue;
            }

            $columns[] = $key;
            $values[] = $value;
            $conditions[] = $key . ' = ? ';
        }

    }

    public function statement(string $sql, array $params = [])
    {
        $connection = $this->getPdo();

        try {
            if (!empty($params)) {
                $stmt = $connection->prepare($sql);

                $result = $stmt->execute($params);

                return $result ?: false;

            }

            return $connection->exec($sql);

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function close()
    {
        return $this->connection = null;
    }

}