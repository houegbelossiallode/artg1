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

# CONFIGURATION APACHE : pointer sur /var/www/html/public ET forcer les autorisations
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf \
    && echo '<Directory /var/www/html/public>\n\tOptions Indexes FollowSymLinks\n\tAllowOverride All\n\tRequire all granted\n</Directory>' >> /etc/apache2/apache2.conf \
    && a2enmod rewrite

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
RUN composer install --no-dev --optimize-autoloader

# Installer Node.js & npm, puis compiler les assets (Tailwind / Vite)
RUN apt-get update && apt-get install -y nodejs npm \
    && npm install \
    && npm run build \
    && rm -rf /var/lib/apt/lists/*

# Donner la propriété des fichiers à l'utilisateur d'Apache (www-data)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Port standard exposé
EXPOSE 80

# Forcer le vidage du cache, exécuter les migrations, puis lancer Apache
CMD  apache2-foreground
