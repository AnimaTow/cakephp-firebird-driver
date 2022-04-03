# CakePHP 4 Driver for Firebird Database

Currently provides data reading, inserting, deleting and updating.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require animatow/cakephp-firebird-driver
```

## Requirements

- CakePHP 4.0+
- an Firebird PHP extension
    - For Ubuntu 14.04 installing see [Ubuntu-PDO](docs/UbuntuPDO.md)
    - or FreeBSD 13 installing see [FreeBSD-PDO](docs/FreeBSDPDO.md)

## Datasource configuration

Here is an example datasource configuration:

```
'myfbconnection' => [
    'className' => 'Cake\Database\Connection',
    'driver' => 'CakephpFirebird\Driver\Firebird',
    'host' => '127.0.0.1',
    'port' => '3050',
    'username' => 'sysdba',
    'password' => 'masterkey',
    'database' => '/path-to-database/database.fdb',
    ]
```

## Known Issues

- disable multiple records insert in the same query (e.g.: fixtures)
- disable auto increment fields on table creation
- review data types
- improve unit tests
- unimplemented add and dropContraints, enable and disableForeignFeySQL

## Workaround

- use cake bake lowercase table name
