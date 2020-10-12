# ./docker/php/Dockerfile
FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    libmcrypt-dev \
    libpq-dev \
    librabbitmq-dev \
    && pecl install amqp \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable amqp

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin