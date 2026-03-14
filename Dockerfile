FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    git \
    unzip \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    nodejs \
    npm \
    nginx \
    supervisor

RUN docker-php-ext-install pdo_mysql bcmath zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm ci && npm run build

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/database

RUN php artisan migrate --force

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
