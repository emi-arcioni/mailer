FROM php:7.1.13-fpm

RUN apt-get update && apt-get install -y zip unzip git libmcrypt-dev mysql-client

RUN docker-php-ext-install mcrypt pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www