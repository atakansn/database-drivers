<?php

namespace DatabaseDrivers\Driver\PDO;

use DatabaseDrivers\Driver\DriverInterface;
use DatabaseDrivers\Exceptions\DriverExtensionNotFoundException;
use DatabaseDrivers\Exceptions\PDOExtensionNotFoundException;
use PDO;
use PDOException;
use Throwable;

abstract class ConnectorObject implements DriverInterface
{
    protected array $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function createConnection(string $dsn, array $config, array $options)
    {
        [$userName, $password] = [
            $config['username'] ?? null,
            $config['password'] ?? null
        ];

        try {
            return $this->createPdoConnection($dsn, $userName, $password, $options);
        } catch (Throwable $t) {
            throw new PDOException($t->getMessage(), (int)$t->getCode());
        }
    }

    protected function createPdoConnection(string $dsn, string $username, string $password, array $options)
    {
        return new PDO($dsn, $username, $password, $options);
    }

    public function getOptions(array $config)
    {
        $options = $config['options'] ?? [];

        return array_diff_key($this->options, $options) + $options;
    }

    public function getDefaultOptions()
    {
        return $this->options;
    }

    public function setDefaultOptions(array $options)
    {
        $this->options = $options;
    }

    protected function extensionControl(...$extName)
    {
        $this->checkPDOExtension();

        foreach ($extName as $ext) {
            if (!extension_loaded($ext)) {
                throw new DriverExtensionNotFoundException("{$ext} extension not found. Please install {$ext} extension.");
            }
        }

        return true;
    }

    /**
     * @throws PDOExtensionNotFoundException
     */
    protected function checkPDOExtension()
    {
        if(!extension_loaded('pdo')) {
            throw new PDOExtensionNotFoundException('PDO extension not found');
        }

        return true;
    }

    protected function getAvailableDrivers()
    {
        return PDO::getAvailableDrivers();
    }


}
