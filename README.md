# PDO Drivers Package

#### Package created to use pdo drivers together.

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

$factory = new \DatabaseDrivers\Connection()
$factory->produce()->query("SELECT * FROM users")->fetchAll();

```