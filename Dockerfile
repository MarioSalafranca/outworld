FROM php:8.2-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
      git \
      curl \
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

WORKDIR /var/www/html

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
