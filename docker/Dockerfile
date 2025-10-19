# docker/Dockerfile
FROM php:8.2-fpm

ARG UID=1000
ARG GID=1000

# System deps
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libjpeg-dev libonig-dev \
    libicu-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev \
    libwebp-dev libxpm-dev gnupg2 libssl-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install -j$(nproc) gd intl pdo pdo_mysql mbstring zip bcmath

# Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install composer binary
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Create non-root user
RUN groupadd -g ${GID} app && useradd -u ${UID} -g app -m -s /bin/bash app

WORKDIR /var/www/html

# Copy composer files first (leverage docker layer cache)
COPY composer.json composer.lock ./

# Install composer deps (production-like install)
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# Copy application source (build context is project root)
COPY . .

# Ensure permissions for storage and cache
RUN chown -R app:app /var/www/html \
 && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

USER app

EXPOSE 9000
CMD ["php-fpm"]
