# FROM php:8.2-apache

# # Dépendances système nécessaires à GD et PostgreSQL
# RUN apt-get update && apt-get install -y \
#     git \
#     zip \
#     unzip \
#     libzip-dev \
#     libpq-dev \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libsodium-dev \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql gd sodium

# # 1. Activer le module de réécriture d'Apache (indispensable pour les routes Laravel)
# RUN a2enmod rewrite

# # 2. Configurer Apache pour écouter sur le port 80 par défaut et définir ServerName
# RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# # Installer Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # Utiliser le dossier standard
# WORKDIR /var/www/html

# # Copier le projet
# COPY . .

# # Variables d'environnement de build pour "tromper" Laravel pendant le composer install
# ENV APP_ENV=production
# ENV APP_KEY=base64:cO1b6jYgqE8uPlXvR2h7K9zNxLmQ4wTpvBaSsDdFfGg=
# ENV DB_CONNECTION=sqlite
# ENV DB_DATABASE=:memory:

# # Installer dépendances PHP
# RUN composer install --no-dev --optimize-autoloader

# # Installer Node.js & npm (pour Vite)
# RUN apt-get update && apt-get install -y nodejs npm

# # Installer les packages frontend et compiler
# RUN npm install && npm run build

# # Nettoyer Node.js après compilation
# RUN apt-get remove -y nodejs npm && apt-get autoremove -y && rm -rf node_modules

# # Permissions Laravel pour Apache
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
#     && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# # Port standard exposé
# EXPOSE 80

# # Créer un script de démarrage pour configurer Apache avec le bon port Render
# RUN echo '#!/bin/bash' > /usr/local/bin/start.sh && \
#     echo 'PORT=${PORT:-80}' >> /usr/local/bin/start.sh && \
#     echo 'sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf' >> /usr/local/bin/start.sh && \
#     echo 'sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/g" /etc/apache2/sites-available/000-default.conf' >> /usr/local/bin/start.sh && \
#     echo 'apache2-foreground' >> /usr/local/bin/start.sh && \
#     chmod +x /usr/local/bin/start.sh

# # Lancer le script de démarrage
# CMD ["/usr/local/bin/start.sh"]



# 1. Image Apache officielle
FROM php:8.2-apache

# Dépendances système nécessaires à GD et MySQL
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libsodium-dev \
    && rm -rf /var/lib/apt/lists/*

# Configuration de GD + Installation de pdo_mysql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql gd sodium \
    && docker-php-ext-enable pdo_mysql

# CONFIGURATION APACHE : Créer une configuration propre pour Laravel
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && a2dismod mpm_event mpm_worker \
    && a2enmod mpm_prefork rewrite \
    && rm -f /etc/apache2/sites-available/000-default.conf \
    && echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf \
    && echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf \
    && echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf \
    && echo '        Options Indexes FollowSymLinks MultiViews' >> /etc/apache2/sites-available/000-default.conf \
    && echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf \
    && echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf \
    && echo '        DirectoryIndex index.php index.html' >> /etc/apache2/sites-available/000-default.conf \
    && echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf \
    && echo '    ErrorLog ${APACHE_LOG_DIR}/error.log' >> /etc/apache2/sites-available/000-default.conf \
    && echo '    CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /etc/apache2/sites-available/000-default.conf \
    && echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier racine d'Apache
WORKDIR /var/www/html

# Copier l'ensemble du projet dans le WORKDIR
COPY . .

# Variables d'environnement de build pour "tromper" Laravel pendant le composer install
ENV APP_ENV=production
ENV APP_KEY=base64:cO1b6jYgqE8uPlXvR2h7K9zNxLmQ4wTpvBaSsDdFfGg=
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=:memory:

# Installer les dépendances PHP sans les packages de dev
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && composer clear-cache

# Installer Node.js & npm, puis compiler les assets (Tailwind / Vite)
RUN apt-get update && apt-get install -y nodejs npm \
    && npm install --production=false \
    && npm run build \
    && npm cache clean --force \
    && rm -rf node_modules \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/*

# Donner la propriété des fichiers à l'utilisateur d'Apache (www-data)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Port standard exposé (Railway gère automatiquement le port)
EXPOSE 80

# Lancer Apache directement (Railway gère le port automatiquement)
CMD ["apache2-foreground"]
