# Usa PHP 8.1 en modo CLI
FROM php:8.1-cli

# Instala git, extensiones necesarias para Laravel + MySQL + ZIP
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    unzip \
  && docker-php-ext-install pdo_mysql zip \
  && rm -rf /var/lib/apt/lists/*

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define el directorio de trabajo
WORKDIR /var/www/html

# Copia solo composer.json y composer.lock e instala dependencias
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copia el resto de tu código
COPY . .

# Expone el puerto 8000
EXPOSE 8000

# Comando por defecto para arrancar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
