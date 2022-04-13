<?php

namespace DatabaseDrivers\PDO;

interface DriverInterface
{

    public function connect(array $config);

    public function getName();

}