FROM php:8.0-apache

WORKDIR /app

ENV APACHE_DOCUMENT_ROOT /app/public
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update \
        && apt-get install -y --no-install-recommends git zip libfreetype6-dev libjpeg62-turbo-dev libjpeg-dev libzip-dev unzip libpng-dev libxml2-dev \
        && apt-get install -y nodejs npm \
        && docker-php-ext-install pdo_mysql bcmath zip soap exif \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
        && rm -rf /var/lib/apt/lists/*

RUN pecl install -o -f redis \
        &&  rm -rf /tmp/pear \
        &&  docker-php-ext-enable redis

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install gd \
        && a2enmod rewrite \
        && pecl install mongodb \
        && docker-php-ext-enable mongodb \
        && pecl install xdebug \
        && docker-php-ext-enable xdebug

ARG COMPOSER_BUILD_ARG

COPY . /app

RUN composer install --no-scripts --no-autoloader $COMPOSER_BUILD_ARG

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
        && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN mkdir -p /app/storage \
        && chmod -R 777 /app/storage/*

# Add build tag
ARG GIT_COMMIT_TAG=default
RUN echo $GIT_COMMIT_TAG > /app/public/nfo.txt
