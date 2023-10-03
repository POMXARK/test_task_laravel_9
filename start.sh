#!/bin/sh

service postgresql restart
sudo -u postgres psql -c "ALTER USER postgres WITH PASSWORD '12345678';"
sudo -u postgres psql -c "create database test_task_laravel_9;"

php composer_2.phar install
php composer_2.phar update --no-scripts
php composer_2.phar dump-autoload

chmod -R 777 storage/logs/
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan config:cache
php artisan migrate
php artisan passport:install

set -e

cron

exec apache2-foreground
