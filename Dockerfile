# ——————————————
# Stage 1: Instalar dependencias con Composer
# ——————————————
FROM php:8.1-cli AS build

# Instalamos git y las librerías necesarias para extensiones de PHP
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

WORKDIR /var/www/html

# Copiamos sólo composer.json y composer.lock
COPY composer.json composer.lock ./

# Traemos Composer y hacemos install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ——————————————
# Stage 2: Imagen de producción
# ——————————————
FROM php:8.1-cli

# Instalamos únicamente las extensiones en runtime
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libonig-dev \
    libxml2-dev \
  && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    bcmath \
    xml \
  && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copiamos el código y el vendor ya generado
COPY --from=build /var/www/html /var/www/html

# Abrimos el puerto 8000
EXPOSE 8000

# Arrancamos el servidor de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
