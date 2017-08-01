FROM php:5.6.31-apache

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    git \
    zlib1g-dev \
    zip \
    unzip

COPY . /var/www/html/
RUN rm -rf /var/www/html/vendor

COPY ./app/000-default.conf /etc/apache2/sites-enabled/
COPY ./app/php.ini /usr/local/etc/php/
COPY ./app/php.ini /usr/local/php

RUN a2enmod rewrite
RUN mkdir -p /var/lib/php/sessions/
RUN chmod -R  777 /var/lib/php/sessions/


