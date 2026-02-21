FROM php:8.2-fpm-alpine as base

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

FROM base as development

RUN php artisan config:clear || true
RUN php artisan cache:clear || true

CMD php artisan migrate:fresh --seed --force && php artisan serve --host=0.0.0.0 --port=9000

FROM base as production

# Create storage directories for images
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

# Fix permissions, create storage directories and link, and run artisan commands as www-data, then start php-fpm as root
CMD chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true && \
    mkdir -p /var/www/html/storage/app/public/images/categories /var/www/html/storage/app/public/images/products 2>/dev/null || true && \
    chown -R www-data:www-data /var/www/html/storage/app/public/images 2>/dev/null || true && \
    su www-data -s /bin/sh -c "php artisan storage:link 2>/dev/null || true && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan event:cache" && \
    php-fpm