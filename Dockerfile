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

FROM php:8.2-cli

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

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier le projet
COPY . .

# =========================================================================
# SOLUTION ICI : Variables d'environnement de build pour "tromper" Laravel
# =========================================================================
ENV APP_ENV=production
ENV APP_KEY=base64:cO1b6jYgqE8uPlXvR2h7K9zNxLmQ4wTpvBaSsDdFfGg=
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=:memory:

# Installer dépendances PHP (Ne plantera plus en cherchant la BDD)
RUN composer install --no-dev --optimize-autoloader

# Installer Node.js & npm (pour Vite)
RUN apt-get update && apt-get install -y nodejs npm

# Installer les packages frontend
RUN npm install

# Compiler les assets pour production
RUN npm run build

# Permissions Laravel (Modifié pour s'assurer que l'utilisateur www-data ou l'hôte possède les accès)
RUN chmod -R 775 storage bootstrap/cache

# Port Render
EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public

# Forcer le vidage du cache, exécuter les migrations, puis lancer Apache
CMD php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan storage:link && php artisan migrate --force && apache2-foreground