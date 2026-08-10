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



FROM php:8.2-apache

# Activer le module de réécriture d'Apache (indispensable pour les routes de Laravel)
RUN a2enmod rewrite

# Dépendances système nécessaires à GD et PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libsodium-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql gd sodium

# Configurer Apache pour pointer sur le dossier /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Utiliser le dossier standard d'Apache
WORKDIR /var/www/html

# Copier le projet
COPY . .

# Variables d'environnement de build pour "tromper" Laravel pendant le composer install
ENV APP_ENV=production
ENV APP_KEY=base64:cO1b6jYgqE8uPlXvR2h7K9zNxLmQ4wTpvBaSsDdFfGg=
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=:memory:

# Installer dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer Node.js & npm (pour Vite)
RUN apt-get update && apt-get install -y nodejs npm

# Installer les packages frontend et compiler
RUN npm install && npm run build

# Nettoyer Node.js après compilation
RUN apt-get remove -y nodejs npm && apt-get autoremove -y && rm -rf node_modules

# Permissions Laravel pour Apache (chown sur www-data est plus propre pour Apache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Port standard exposé
EXPOSE 80

# Exécuter les commandes et lancer Apache en tâche de fond
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan storage:link && \
    apache2-foreground