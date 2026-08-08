# 1. Utiliser impérativement l'image avec Apache au lieu de -cli
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

# Configuration de GD + Installation de pdo_mysql pour Aiven
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql gd sodium \
    && docker-php-ext-enable pdo_mysql

# Activer le module de réécriture d'Apache (indispensable pour les routes Laravel)
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail standard pour Apache
WORKDIR /var/www

# Copier le projet
COPY . .

# Créer un fichier .env temporaire pour éviter les erreurs SQLite pendant le build
RUN cp .env.example .env && \
    sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env && \
    sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=127.0.0.1/' .env && \
    sed -i 's/# DB_PORT=3306/DB_PORT=3306/' .env && \
    sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=laravel/' .env && \
    sed -i 's/# DB_USERNAME=root/DB_USERNAME=root/' .env && \
    sed -i 's/# DB_PASSWORD=/DB_PASSWORD=/' .env

# Créer le fichier database.sqlite vide pour éviter les erreurs pendant le build
RUN touch database/database.sqlite

# Installer dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Installer Node.js & npm (pour compiler Tailwind avec Vite)
RUN apt-get update && apt-get install -y nodejs npm

# Installer les packages frontend et compiler les assets
RUN npm install && npm run build

# Permissions correctes pour le serveur Apache (www-data)
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Port standard pour les conteneurs web
EXPOSE 80

# Exécuter les migrations automatiques puis démarrer Apache proprement
CMD php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan storage:link && php artisan migrate --force && apache2-foreground
