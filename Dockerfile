FROM debian
FROM php:fpm-alpine

LABEL application="starwars"
# RUN apt-get -y update
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pgsql pdo_pgsql mbstring
# RUN apk add php-redis
RUN set -xe \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install -o -f redis  \
    && docker-php-ext-enable redis\
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && rm -rf /usr/share/php \
    && rm -rf /tmp/* \
    && apk del  .phpize-deps


RUN mkdir /app
WORKDIR /app
COPY . /app
RUN composer install
RUN composer dump-autoload