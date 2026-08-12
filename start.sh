#!/bin/bash

# Configuration en cache pour optimiser les performances
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exécution des migrations de base de données
# (Nécessaire si vous utilisez une base de données managée sur Render)
php artisan migrate --force
# Configuration dynamique du port d'Apache pour Render
# (Render fournit la variable d'environnement $PORT, par défaut 10000)
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf

# Démarrage d'Apache en premier plan
apache2-foreground
