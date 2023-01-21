<?php

namespace DatabaseDrivers\Driver;

interface DriverInterface
{
    /**
     * @param array $config
     * @return mixed
     */
    public function connect(array $config);

    /**
     * @return mixed
     */
    public function getName();
}
