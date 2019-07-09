#!/usr/bin/env bash

./getcomposer.sh

php composer.phar install

php -r "file_exists('.env') || copy('.env.example', '.env');"

php artisan key:generate --ansi

php artisan migrate:refresh --seed

php artisan passport:install

chmod -R 777 storage
