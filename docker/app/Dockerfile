FROM ghcr.io/roadrunner-server/roadrunner:latest AS roadrunner

FROM php:8.3-cli

WORKDIR /var/www/app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr

RUN apt-get update && apt-get install -y zlib1g-dev libmemcached-dev g++ git libicu-dev zip libzip-dev libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo pdo_pgsql pgsql sockets \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip