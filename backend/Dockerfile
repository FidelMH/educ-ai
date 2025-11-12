FROM php:8.2-fpm

# Arguments
ARG user=laravel
ARG uid=1000

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer un utilisateur
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
 && mkdir -p /home/$user/.composer \
 && chown -R $user:$user /home/$user

# Répertoire de travail
WORKDIR /var/www

# Copier le projet
COPY . /var/www

# Créer le dossier vendor avec bonnes permissions
RUN mkdir -p /var/www/vendor \
 && chown -R $user:www-data /var/www/vendor \
 && chown -R $user:www-data /var/www

# Utiliser l'utilisateur
USER $user

# Exposer le port
EXPOSE 8000

# Commande par défaut
CMD ["sh", "-c", "composer install && php artisan serve --host=0.0.0.0 --port=8000"]
