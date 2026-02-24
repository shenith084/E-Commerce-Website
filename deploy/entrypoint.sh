#!/bin/bash

# Start PHP-FPM
php-fpm -D

# Run migrations if database is ready
php artisan migrate --force

# Start Nginx
nginx -g "daemon off;"
