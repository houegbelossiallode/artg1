FROM php:8.2-apache

# Configuration d'environnement pour que Composer puisse fonctionner sans alertes
ENV COMPOSER_ALLOW_SUPERUSER=1

# 1. Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Nettoyage du cache APT
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Installation des extensions PHP requises par Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Configuration d'Apache
# Activation du module mod_rewrite pour Apache
RUN a2enmod rewrite

# Modification du DocumentRoot d'Apache pour pointer vers le dossier public/ de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /var/www/html

# Variables d'environnement de build
ENV APP_ENV=production
ENV APP_KEY=base64:cO1b6jYgqE8uPlXvR2h7K9zNxLmQ4wTpvBaSsDdFfGg=
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=:memory:
ENV COMPOSER_ALLOW_SUPERUSER=1

# Copie des fichiers composer avant le reste du code (optimisation du cache Docker)
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --no-scripts --no-autoloader

# 5. Copie du code de l'application
COPY . .

# Définition des permissions correctes
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Finalisation de l'installation PHP
RUN composer dump-autoload --optimize \
    && composer run-script post-root-package-install || true \
    && composer run-script post-create-project-cmd || true

# 6. Installation des dépendances Node et compilation des assets (Vite/Tailwind)
RUN npm install
RUN npm run build
RUN rm -rf node_modules

# 7. Copie et configuration du script de démarrage
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
# Convertir les fins de ligne au cas où le script est créé sous Windows
RUN sed -i -e 's/\r$//' /usr/local/bin/start.sh

# 8. Exposition du port et lancement
EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
