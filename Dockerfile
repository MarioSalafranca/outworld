# Usa PHP 8.1 CLI
FROM php:8.1-cli

# Instala git, zip y extensiones necesarias
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
      git \
      zip unzip \
      libzip-dev \
      libonig-dev \
      libxml2-dev && \
    docker-php-ext-install \
      pdo_mysql \
      mbstring \
      zip \
      bcmath \
      xml && \
    rm -rf /var/lib/apt/lists/*

# Directorio de trabajo
WORKDIR /var/www/html

# Copia todo el código del proyecto (incluye artisan)
COPY . .

# Instala Composer y luego las dependencias PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Expone el puerto de Laravel
EXPOSE 8000

# Comando por defecto
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
