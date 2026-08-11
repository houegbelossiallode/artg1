#!/bin/bash
set -e

echo "=== Starting application ==="

# Créer les répertoires de logs
mkdir -p /var/log/php-fpm /var/log/nginx
touch /var/log/php-fpm/error.log /var/log/nginx/error.log /var/log/nginx/access.log
chown www-data:www-data /var/log/php-fpm /var/log/php-fpm/error.log /var/log/nginx/error.log /var/log/nginx/access.log

echo "=== Running Laravel setup ==="
php /var/www/html/artisan config:cache || true
php /var/www/html/artisan route:cache || true
php /var/www/html/artisan view:cache || true

echo "=== Starting PHP-FPM ==="
php-fpm -D

echo "=== Waiting for PHP-FPM ==="
sleep 2

echo "=== Starting Nginx ==="
nginx -g "daemon off;" -c /etc/nginx/nginx.conf

