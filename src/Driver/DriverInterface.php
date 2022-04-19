<?php

namespace DatabaseDrivers\Driver;

interface DriverInterface
{

    public function connect(array $config);

    public function getName();

}