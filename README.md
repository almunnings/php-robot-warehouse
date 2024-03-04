# Robot Warehouse

## Lando

https://lando.dev/download/

```bash
lando start
lando run
lando test
```

## Docker

```bash
docker run --rm --interactive --tty --volume $PWD:/app composer/composer install
docker run --rm --interactive --tty --volume $PWD:/app -w /app php:8.2-cli php app/index.php
docker run --rm --interactive --tty --volume $PWD:/app -w /app php:8.2-cli phpunit
```

## Normal PHP 8.2+

```bash
composer install
php app/index.php
phpunit
```
