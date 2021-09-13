#
# Proxy
#
FROM traefik:alpine as proxy

WORKDIR /code

COPY docker/traefik.toml /etc/traefik

#
# Frontend
#
FROM nginx:alpine as frontend

WORKDIR /code

COPY docker/default.conf /etc/nginx/conf.d

#
# Backend
#
FROM php:7.4-fpm-alpine as backend

WORKDIR /code

RUN docker-php-ext-install opcache pdo_mysql

RUN pecl install redis
RUN docker-php-ext-enable redis

COPY docker/php.ini /usr/local/etc/php
COPY docker/opcache.ini /usr/local/etc/php/conf.d

#
# Artisan
#
FROM php:7.4-cli-alpine as artisan

WORKDIR /code

COPY scheduler /usr/local/bin

RUN docker-php-ext-install pcntl pdo_mysql

RUN pecl install redis
RUN docker-php-ext-enable redis
