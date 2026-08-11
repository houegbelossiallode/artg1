#!/bin/bash
set -e

echo "=== Starting application ==="

# Créer les répertoires de logs
mkdir -p /var/log/php-fpm /var/log/nginx
touch /var/log/php-fpm/error.log /var/log/nginx/error.log /var/log/nginx/access.log
chown www-data:www-data /var/log/php-fpm /var/log/php-fpm/error.log /var/log/nginx/error.log /var/log/nginx/access.log

echo "=== Ensuring database directory exists ==="
mkdir -p /var/www/html/database
chown -R www-data:www-data /var/www/html/database
chmod -R 775 /var/www/html/database

if [ "$DB_CONNECTION" = "sqlite" ]; then
    DB_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    if [ ! -f "$DB_PATH" ]; then
        echo "=== Creating SQLite database file at $DB_PATH ==="
        touch "$DB_PATH"
        chown www-data:www-data "$DB_PATH"
        chmod 664 "$DB_PATH"
    fi
fi

echo "=== Running database migrations ==="
php /var/www/html/artisan migrate --force

echo "=== Seeding database ==="
php /var/www/html/artisan db:seed --force || true

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

