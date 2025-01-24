FROM php:7.4.3-fpm-alpine3.11 

RUN apk --no-cache add postgresql-dev && docker-php-ext-install pdo pdo_pgsql

WORKDIR /app

COPY . /app
VOLUME ["/app"]