#!/bin/bash

# 1. On lance les migrations
php artisan migrate --force

# 2. Configuration INFAILLIBLE d'Apache pour Render
# On récupère le port de Render (ou 10000 par défaut)
PORT=${PORT:-10000}

# On écrase totalement la configuration des ports pour être sûr à 100% qu'il écoute sur 0.0.0.0 et sur le bon port
echo "Listen 0.0.0.0:$PORT" > /etc/apache2/ports.conf

# On écrase totalement le VirtualHost pour qu'il pointe vers le bon dossier public avec le bon port
echo "<VirtualHost *:$PORT>
    DocumentRoot /var/www/html/public
    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

# 3. Lancement d'Apache
apache2-foreground
