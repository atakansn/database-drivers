# PDO Drivers Package

#### Package created to use pdo drivers together.
<p align="center">
  <img src="https://i.ibb.co/dsNQC10/indir.png">
</p>
  <img width="100" src="https://i.ibb.co/mHxgDdF/postgres.png">  
<img width="100" src="https://i.ibb.co/82qBcJf/sqlite.png">
<img width="100" src="https://i.ibb.co/47BwmqF/sqlserver.png">
<img width="100" src="https://i.ibb.co/YkdJhL6/mysql.png">


#### Installation


````dotenv
DB_CONNECTION=mysql,pgsql,sqlsrv,sqlite
DB_HOST=host
DB_PORT=port
DB_USERNAME=username
DB_PASSWORD=password
DB_DATABASE=database
````

```php
require __DIR__ . '/vendor/autoload.php';

$manager = \DatabaseDrivers\Driver\Manager::run()

/**
* Example :
* $manager->statement('create table table_name (column1 datatype,column1 datatype,');
 * $manager->statement('drop table table_name');
 * $manager->statement('insert into table_name(column1,column2') values(':column1',':column2'),[':column1'=>'value',':column2'=>'value',]);
*/
$manager->statement($sql,$params,$type);

$manager->insert($table,$params,$type);
```