<?php

require __DIR__ . '/vendor/autoload.php';


$factory = new DatabaseDrivers\ConnectionFactory();


print_r($factory->produce()->query('SELECT * FROM table_name')->fetchAll());




