FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    bash git unzip libicu-dev libzip-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Apache rewrite
RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

#ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
#    /etc/apache2/sites-available/000-default.conf \
#    /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini





