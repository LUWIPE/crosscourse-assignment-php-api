FROM php:8.4-cli-alpine

# System dependencies needed by Laravel and Composer.
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    postgresql-dev \
    mysql-client

# PHP extensions used by Laravel and common DB drivers.
RUN docker-php-ext-install \
    bcmath \
    intl \
    mbstring \
    pdo \
    pdo_mysql \
    pdo_pgsql

# Bring in Composer binary.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies first for better layer caching.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy application source.
COPY . .

# Ensure runtime directories are writable.
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Render provides PORT at runtime.
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
