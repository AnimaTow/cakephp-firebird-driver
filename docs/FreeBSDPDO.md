
# FreeBSD Firebird PDO installing

```
pkg install php80-pdo_firebird-8.0.15
```

Check:

```
php -i | grep PDO
```

Should return:

```
PDO
PDO support => enabled
PDO drivers => firebird, mysql, sqlite
PDO_Firebird
PDO Driver for Firebird => enabled
PDO Driver for MySQL => enabled
PDO Driver for SQLite 3.x => enabled
```
