# FROM php:8.2-cli

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
#     && docker-php-ext-install zip pdo pdo_pgsql gd sodium

# # Installer Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www

# # Copier le projet
# COPY . .

# # Installer dépendances PHP
# RUN composer install --no-dev --optimize-autoloader

# # Installer Node.js & npm (pour Vite)
# RUN apt-get update && apt-get install -y nodejs npm

# # Installer les packages frontend
# RUN npm install


# # Compiler les assets pour production
# RUN npm run build


# # Permissions Laravel
# RUN chmod -R 775 storage bootstrap/cache

# # Port Render
# EXPOSE 10000

# CMD php -S 0.0.0.0:10000 -t public

# FROM php:8.2-cli

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

# # Installer Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www

# # Copier le projet
# COPY . .

# # =========================================================================
# # SOLUTION ICI : Variables d'environnement de build pour "tromper" Laravel
# # =========================================================================
# ENV APP_ENV=production
# ENV APP_KEY=base64:cO1b6jYgqE8uPlXvR2h7K9zNxLmQ4wTpvBaSsDdFfGg=
# ENV DB_CONNECTION=sqlite
# ENV DB_DATABASE=:memory:

# # Installer dépendances PHP (Ne plantera plus en cherchant la BDD)
# RUN composer install --no-dev --optimize-autoloader

# # Installer Node.js & npm (pour Vite)
# RUN apt-get update && apt-get install -y nodejs npm

# # Installer les packages frontend
# RUN npm install

# # Compiler les assets pour production
# RUN npm run build

# # Permissions Laravel (Modifié pour s'assurer que l'utilisateur www-data ou l'hôte possède les accès)
# RUN chmod -R 775 storage bootstrap/cache

# # Port Render
# EXPOSE 10000

# CMD php -S 0.0.0.0:10000 -t public

# # Forcer le vidage du cache, exécuter les migrations, puis lancer Apache
# CMD php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan storage:link && php artisan migrate --force


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

# # Installer Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www

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

# # Nettoyer Node.js après compilation pour alléger l'image finale
# RUN apt-get remove -y nodejs npm && apt-get autoremove -y && rm -rf node_modules

# # Permissions Laravel
# RUN chmod -R 775 storage bootstrap/cache

# # Port standard exposé
# EXPOSE 80

# # Forcer le vidage du cache, exécuter les migrations, puis lancer Apache
# CMD php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan storage:link && apache2-foreground



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
CMD php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan storage:link && php artisan migrate --force && apache2-foreground