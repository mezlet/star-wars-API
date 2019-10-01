FROM debian
FROM php:fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pgsql pdo_pgsql mbstring

RUN mkdir /app
WORKDIR /app
COPY . /app
RUN composer install
