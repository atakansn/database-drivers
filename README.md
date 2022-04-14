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
use DatabaseDrivers\PDO\ConnectorFactory;

require __DIR__ . '/vendor/autoload.php';

$factory = new ConnectorFactory();

print_r($factory->produce()->query("SELECT * FROM migrations")->fetchAll());

// OR

// use pdo() method.

```