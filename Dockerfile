

FROM php:8.2-apache



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

# 1. Activer le module de réécriture d'Apache (indispensable pour les routes Laravel)
RUN a2enmod rewrite

# 2. Configurer Apache pour écouter sur le port Render et définir ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i 's/Listen 80/Listen ${PORT:-10000}/g' /etc/apache2/ports.conf

# 3. Réécrire le VirtualHost par défaut pour écouter sur le port Render
RUN echo '<VirtualHost *:${PORT:-10000}>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Options Indexes FollowSymLinks MultiViews' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Utiliser le dossier standard
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

# Permissions Laravel pour Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Port Render (exposer le port 10000 par défaut)
EXPOSE 10000

# Lancer Apache directement
CMD apache2-foreground
