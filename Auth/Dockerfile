FROM php:7.4-apache
FROM composer:2.0 as vendor

WORKDIR /app

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

EXPOSE 8000

COPY . .

CMD [ "php", "-S", "0.0.0.0:8000"]

