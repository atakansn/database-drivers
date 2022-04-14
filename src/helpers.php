<?php

if(!function_exists('config_path')) {

    function config_path()
    {
        return sprintf('%s/%s',getcwd(),'config/');
    }
}

if(!function_exists('config')) {

    function config($file)
    {
        return require sprintf('%s/%s.php',config_path(),$file);
    }
}

if(!function_exists('env')) {

    function env($name,$default=null)
    {
        return (new \DatabaseDrivers\Env('.env'))->getValue($name) ?: $default;
    }
}

if(!function_exists('pdo')) {

    function pdo()
    {
        return (new \DatabaseDrivers\PDO\ConnectorFactory())->produce();
    }
}