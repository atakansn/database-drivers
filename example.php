<?php

require __DIR__ . '/vendor/autoload.php';

$manager = \DatabaseDrivers\Driver\ConnectionManager::run();

print_r($manager->getPdo());