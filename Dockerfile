FROM php:8.4.1-fpm-alpine
RUN apk update && apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    shadow \
    autoconf \
    gcc \
    g++ \
    make \
    && docker-php-ext-install pdo pdo_mysql \
    && pecl install redis \
    && docker-php-ext-enable redis
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www
COPY . .
RUN chown -R www-data:www-data storage bootstrap/cache
RUN composer install
EXPOSE 80
CMD ["php-fpm"]