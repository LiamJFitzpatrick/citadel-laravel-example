# Stage 1: Build PHP & Node Assets together
FROM php:8.3-fpm-alpine AS builder

# Install system dependencies, PHP extensions, AND Node.js/npm
RUN apk add --no-cache \
    git \
    unzip \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    nodejs \
    npm

RUN docker-php-ext-install pdo_mysql bcmath zip

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# 1. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 2. Install Node dependencies and build assets
# Now 'php artisan' will work during 'npm run build'
RUN npm ci && npm run build

# Stage 2: Final Production Image
FROM php:8.3-fpm-alpine
WORKDIR /var/www

# Copy the entire built application from the builder stage
COPY --from=builder /var/www /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
