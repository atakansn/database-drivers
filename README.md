# PDO Drivers Package

#### Package created to use pdo drivers together.
<p align="center">
  <img src="https://i.ibb.co/dsNQC10/indir.png">
</p>
<div>
  <img width="100" src="https://i.ibb.co/mHxgDdF/postgres.png">  
<img width="100" src="https://i.ibb.co/82qBcJf/sqlite.png">
<img width="100" src="https://i.ibb.co/47BwmqF/sqlserver.png">
<img width="100" src="https://i.ibb.co/YkdJhL6/mysql.png">
</div>


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
use DatabaseDrivers\PDO\ConnectorFactory;

require __DIR__ . '/vendor/autoload.php';

$factory = new ConnectorFactory();

print_r($factory->produce()->query("SELECT * FROM migrations")->fetchAll());

// OR

// use pdo() method.

```