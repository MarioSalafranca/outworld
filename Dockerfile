# ——————————————————————————————
# 1) Imagen base para PHP 8.3 y extensiones
# ——————————————————————————————
FROM php:8.3-cli AS base

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

# ——————————————————————————————
# 2) Instalación de dependencias con Composer
# ——————————————————————————————
FROM base AS build

# Trae Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia composer.json/lock e instala
COPY composer.json composer.lock ./
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ——————————————————————————————
# 3) Imagen final
# ——————————————————————————————
FROM base

WORKDIR /var/www/html

# Copia código + vendor ya instalado
COPY --from=build /var/www/html /var/www/html

# Expone el puerto de Laravel
EXPOSE 8000

# Arranca el servidor de desarrollo de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
