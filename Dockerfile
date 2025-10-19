FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev \
    libonig-dev libxml2-dev

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY --chown=www-data:www-data . /var/www/html

CMD ["php-fpm"]