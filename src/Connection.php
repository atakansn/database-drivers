<?php

namespace DatabaseDrivers;

use DatabaseDrivers\Driver\DriverInterface;
use PDO;
use PDOException;
use Exception;

class Connection
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var DriverInterface
     */
    private DriverInterface $driver;

    /**
     * @var
     */
    private $connection;

    /**
     * @var string
     */
    private string $connectionName;

    /**
     * @param DriverInterface $driver
     * @param array $config
     * @param string $connectionName
     */
    public function __construct(DriverInterface $driver, array $config, string $connectionName)
    {
        $this->config = $config;

        $this->driver = $driver;

        $this->connectionName = $connectionName;

    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->connection !== null;
    }

    /**
     * @return bool
     */
    public function connect()
    {
        if ($this->connection !== null) {
            return false;
        }

        try {
            $this->connection = $this->driver->connect($this->config);
        } catch (Exception $e) {
            $this->close();
            throw new PDOException($e->getMessage(), $e->getCode());
        }

        return true;
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        $this->connect();

        return $this->connection;
    }

    /**
     * @param string $table
     * @param array $data
     * @return bool|int|null
     */
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

    /**
     * @param string $table
     * @param array $data
     * @param array $condition
     * @return bool|int|null
     */
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

    /**
     * @param string $table
     * @param array $data
     * @return bool|int|null
     */
    public function delete(string $table, array $data)
    {
        $columns = $values = $conditions = [];

        $this->conditionReferance($data, $columns, $values, $conditions);

        return $this->statement(
            'DELETE FROM ' . $table . ' WHERE ' . implode(' AND ', $conditions),
            $values
        );
    }

    /**
     * @param array $criteria
     * @param array $columns
     * @param array $values
     * @param array $conditions
     * @return void
     */
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

    /**
     * @param string $sql
     * @param array $params
     * @return bool|int|void
     */
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

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return null
     */
    public function close()
    {
        return $this->connection = null;
    }

}
