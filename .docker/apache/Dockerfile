FROM php:7.4-apache

RUN pecl install xdebug \
    && apt update \
    && apt install -y git libzip-dev zip \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY .docker/apache/sf4.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/html/symfony
