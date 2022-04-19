<?php

namespace DatabaseDrivers\Driver\PDO;

use PDO;

class ConnectionObject
{
    protected $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function createConnection($dsn,$config,$options)
    {
        [$userName,$password] = [
          $config['username'] ?? null,
          $config['password'] ?? null
        ];

        try{
            return $this->createPdoConnection($dsn,$userName,$password,$options);
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function createPdoConnection($dsn,$username,$password,$options)
    {
        return new PDO($dsn,$username,$password,$options);
    }

    public function getOptions(array $config)
    {
        $options = $config['options'] ?? [];

        return array_diff_key($this->options,$options) + $options;
    }

    public function getDefaultOptions()
    {
        return $this->options;
    }

    public function setDefaultOptions(array $options)
    {
        $this->options = $options;
    }





}