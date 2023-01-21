<p align="center">
  <img src="https://www.php.net/images/logos/new-php-logo.png">
</p>

# PDO Drivers Package

Package created to use pdo drivers together.

## Supported Drivers

- MySQL
- PostgreSQL
- SQLServer
- SQLite

## Requirements

- PHP >= 8.0
- ext-pdo

## Bilgisayarınızda Çalıştırın

Projeyi klonlayın

```bash
  git clone https://github.com/atakansn/database-drivers.git
```

Proje dizinine gidin

```bash
  cd database-drivers
```

Gerekli paketleri yükleyin

```bash
  composer install
```

## Usage/Examples

````dotenv
DB_CONNECTION=database-driver
DB_HOST=host
DB_PORT=port
DB_USERNAME=username
DB_PASSWORD=password
DB_DATABASE=database
````

```php
require __DIR__ . '/vendor/autoload.php';

$manager = \DatabaseDrivers\Driver\ConnectionManager::run()

$manager->insert('test_table', [
    'name' => 'Foo'
]);

$manager->update('test_table',
    ['name' => 'Foo Bar'], // new value
    ['id'=> 2] // conditions
);

$manager->delete('test_table', [
    'id' => 3
]);
```

### SQL Outputs
```sql
INSERT INTO test_table(name) VALUES('Foo')


UPDATE test_table SET name='Foo Bar' WHERE id=2


DELETE FROM test_table WHERE id=2
```

### PDO Instance

````php
$manager = \DatabaseDrivers\Driver\ConnectionManager::run();
$pdo = $manager->getPdo();
$stmt = $pdo->prepare('SELECT * FROM table_name');
$stmt->execute();
````

### config/database.php Config File

Can configure PDO connection settings, disable.

````php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST'),
    'port' => env('DB_PORT',3306),
    'database' => env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
],

'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST'),
    'port' => env('DB_PORT',5432),
    'database' => env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset' => 'utf8',
    'search_path' => 'public',
    //'ssl_mode' => 'prefer',
],

'sqlsrv' => [
    'driver' => 'sqlsrv',
    'host' => env('DB_HOST'),
    'port' => env('DB_PORT'),
    'database' => env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset' => 'utf8',
],

'sqlite' => [
    'driver' => 'sqlite',
    'url' => env('DATABASE_URL'),
    'database' => database_path(env('DB_DATABASE')),
    'foreign_key_constraints' => env('DB_FOREIGN_KEYS')
]
````


