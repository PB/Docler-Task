FROM php:8-alpine

COPY . /var/www

# install composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN COMPOSER_ALLOW_SUPERUSER=1 \
 && composer install -d /var/www \
                     --no-progress  \
                     --no-suggest \
                     --optimize-autoloader \
                     --ignore-platform-reqs

# install pdo
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql