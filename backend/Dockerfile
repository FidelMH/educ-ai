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
    unzip

# Nettoyage du cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Création de l'utilisateur système
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers du projet
COPY . /var/www

# Permissions
RUN chown -R $user:www-data /var/www

# Utiliser l'utilisateur créé
USER $user

# Exposer le port 8000
EXPOSE 8000

# Commande par défaut
CMD ["sh", "-c", "composer install && php artisan serve --host=0.0.0.0 --port=8000"]
