#!/bin/bash

# 1. On lance les migrations (si ça échoue à cause de "Too many connections", le script continue)
php artisan migrate --force || true

# 2. Lancement du serveur intégré de Laravel
# C'est la méthode 100% garantie pour que Render détecte le port ouvert immédiatement.
PORT=${PORT:-10000}
echo "Starting Laravel on 0.0.0.0:$PORT"
php artisan serve --host=0.0.0.0 --port=$PORT
