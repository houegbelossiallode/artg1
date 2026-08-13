#!/bin/bash

# 1. Mise en cache de la configuration (TRÈS IMPORTANT sur Render pour lire les variables d'environnement)
php artisan config:clear
php artisan config:cache
php artisan view:clear

# 2. On lance les migrations et les seeders
php artisan migrate --force || true
php artisan db:seed --force || true

# 2. Lancement du serveur intégré de Laravel
# C'est la méthode 100% garantie pour que Render détecte le port ouvert immédiatement.
PORT=${PORT:-10000}
echo "Starting Laravel on 0.0.0.0:$PORT"
php artisan serve --host=0.0.0.0 --port=$PORT
