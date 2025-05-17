# Usa PHP 8.1 en modo CLI
FROM php:8.1-cli

# Instala git, zip y las librerías para las extensiones PHP
RUN apt-get update && apt-get install -y \
    git \
    zip unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
  && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    bcmath \
    xml \
  && rm -rf /var/lib/apt/lists/*

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copia sólo composer.json y composer.lock e instala dependencias
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copia el resto de tu código
COPY . .

# Expone el puerto 8000
EXPOSE 8000

# Arranca el servidor de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
