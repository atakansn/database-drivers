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

if(!function_exists('database_path')) {

    function database_path($name)
    {
        return sprintf('%s/%s/',getcwd(),"database/$name");
    }
}

if(!function_exists('env')) {

    function env($name,$default=null)
    {
        return (new \DatabaseDrivers\Env('.env'))->getValue($name) ?: $default;
    }
}

if(!function_exists('pdo')) {

    function pdo($connection = 'mysql')
    {
        return (\DatabaseDrivers\Driver\ConnectionManager::run($connection))->getPdo();
    }
}

if (!function_exists('managerRun')) {

    function managerRun($connectionName = 'mysql')
    {
        return \DatabaseDrivers\Driver\ConnectionManager::run($connectionName);
    }
}
