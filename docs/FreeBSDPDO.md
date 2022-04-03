
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
PDO_Firebird
PDO Driver for Firebird/InterBase => enabled
```
