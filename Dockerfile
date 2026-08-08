# # 1. Utiliser impérativement l'image avec Apache au lieu de -cli
# FROM php:8.2-apache

# # Dépendances système nécessaires à GD et MySQL
# RUN apt-get update && apt-get install -y \
#     git \
#     zip \
#     unzip \
#     libzip-dev \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libsodium-dev \
#     && rm -rf /var/lib/apt/lists/*

# # Configuration de GD + Installation de pdo_mysql pour Aiven
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install zip pdo pdo_mysql gd sodium \
#     && docker-php-ext-enable pdo_mysql

# # Activer le module de réécriture d'Apache (indispensable pour les routes Laravel)
# RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
# RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf \
#     && a2enmod rewrite

# # Installer Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # Définir le dossier de travail standard pour Apache
# WORKDIR /var/www

# # Copier le projet
# COPY . .

# # Installer dépendances PHP
# RUN composer install --no-dev --optimize-autoloader

# # Installer Node.js & npm (pour compiler Tailwind avec Vite)
# RUN apt-get update && apt-get install -y nodejs npm

# # Installer les packages frontend et compiler les assets
# RUN npm install && npm run build

# # Permissions correctes pour le serveur Apache (www-data)
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
#     && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# # Port standard pour les conteneurs web
# EXPOSE 80

# # Exécuter les migrations automatiques puis démarrer Apache proprement
# CMD php artisan migrate --force && apache2-foreground




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