FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    mysql-client \
    linux-headers \
    $PHPIZE_DEPS \
    && docker-php-ext-install pdo pdo_mysql \
    && apk del $PHPIZE_DEPS

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && composer --version

COPY composer.json composer.lock* ./

RUN if [ -f composer.lock ]; then \
        composer install --no-dev --optimize-autoloader --no-scripts; \
    else \
        composer update --no-dev --optimize-autoloader --no-scripts --prefer-dist; \
    fi

COPY . .

RUN composer dump-autoload --optimize \
    && php artisan key:generate --force || true
