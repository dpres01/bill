FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public/index.php/

RUN cd /var/www/html\
    && curl -sS https://getcomposer.org/installer | php \
    && php composer.phar install --no-plugins --no-scripts\
    && apt-get update\
    && docker-php-ext-install mysqli pdo pdo_mysql\
    && docker-php-ext-enable pdo_mysql
    #&& php bin/console doctrine:schema:update --force

    RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
    RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf