<?php

use DatabaseDrivers\PDO\ConnectorFactory;

require __DIR__ . '/vendor/autoload.php';

$factory = new ConnectorFactory();

print_r($factory->produce()->query("SELECT * FROM migrations")->fetchAll());

// OR

// pdo()



