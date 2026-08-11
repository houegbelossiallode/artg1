# Stage 1: Builder - Construire les assets et dépendances
FROM php:8.2-fpm as builder

WORKDIR /build

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libsodium-dev \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Configurer et installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql pdo_sqlite gd sodium \
    && docker-php-ext-enable pdo_mysql pdo_sqlite

# Copier Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le code
COPY . .

# Variables d'environnement de build
ENV APP_ENV=production
ENV APP_KEY=base64:cO1b6jYgqE8uPlXvR2h7K9zNxLmQ4wTpvBaSsDdFfGg=
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=:memory:

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && composer clear-cache

# Compiler les assets (Tailwind / Vite)
RUN npm install --production=false \
    && npm run build \
    && npm cache clean --force \
    && rm -rf node_modules

# Stage 2: Runtime - Image finale avec Nginx + PHP-FPM
FROM php:8.2-fpm

# Installer Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libsodium-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql pdo_sqlite gd sodium \
    && docker-php-ext-enable pdo_mysql pdo_sqlite

# Copier la config PHP-FPM
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini

# Copier la config Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/site.conf /etc/nginx/sites-available/default

# Définir le WORKDIR
WORKDIR /var/www/html

# Copier les fichiers compilés depuis le builder
COPY --from=builder /build .

# Créer le répertoire de la base de données et donner les droits à www-data
RUN mkdir -p /var/www/html/database \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/database

# Créer les répertoires Nginx s'ils n'existent pas
RUN mkdir -p /var/log/nginx /var/run/nginx

# Exposer le port
EXPOSE 80

# Script d'entrée pour démarrer PHP-FPM et Nginx
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]

