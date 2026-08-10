#!/bin/bash
set -e

# Créer les répertoires de logs
mkdir -p /var/log/php-fpm
touch /var/log/php-fpm/error.log
chown www-data:www-data /var/log/php-fpm /var/log/php-fpm/error.log

# Démarrer PHP-FPM en arrière-plan
php-fpm -D

# Attendre que PHP-FPM soit prêt
sleep 2

# Démarrer Nginx en avant-plan
nginx -g "daemon off;"

