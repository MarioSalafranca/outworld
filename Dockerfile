# Imagen base con PHP 8.1
FROM php:8.1-cli

# Instala herramientas del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    zip unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
  && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    bcmath \
    xml \
    intl \
  && rm -rf /var/lib/apt/lists/*

# Directorio de trabajo
WORKDIR /var/www/html

# Copia todo el código primero (incluye artisan)
/usr/bin/composer ./
COPY . .

# Copia Composer desde la imagen oficial y fuerza memoria ilimitada
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1

# Instala las dependencias de PHP (ahora artisan existe y las scripts funcionan)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Exponemos el puerto 8000 para Laravel
EXPOSE 8000

# Comando por defecto para arrancar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
