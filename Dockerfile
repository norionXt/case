FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip dom

RUN docker-php-ext-enable pdo pdo_mysql zip dom

RUN docker-php-ext-enable pdo pdo_mysql zip dom
