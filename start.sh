#!/bin/bash

# Configuration en cache pour optimiser les performances
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exécution des migrations de base de données
# (Nécessaire si vous utilisez une base de données managée sur Render)
php artisan migrate --force

# Démarrage d'Apache en premier plan
apache2-foreground
