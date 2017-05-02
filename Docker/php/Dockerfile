FROM php:7.1.4-apache
MAINTAINER Jakub Turek <ja@kubaturek.pl>

ENV COMPOSER_ALLOW_SUPERUSER 1

# SYSTEM PACKAGES
RUN apt-get update
RUN apt-get -y install wget git zlib1g-dev libicu-dev sqlite3 libsqlite3-dev

# PHP EXTENSIONS
RUN docker-php-ext-install zip intl pdo_mysql pdo_sqlite
RUN pecl install apcu-5.1.8
RUN docker-php-ext-enable --ini-name 20-apcu.ini apcu
RUN docker-php-ext-enable --ini-name 05-opcache.ini opcache

# COMPOSER
COPY composer.sh /usr/local/bin/install-composer
RUN chmod +x /usr/local/bin/install-composer
RUN install-composer && mv composer.phar /usr/local/bin/composer
RUN composer global require "hirak/prestissimo:^0.3" --optimize-autoloader --classmap-authoritative --no-progress --prefer-dist

# APACHE
RUN rm /etc/apache2/sites-available/* /etc/apache2/sites-enabled/*
COPY vhost.conf /etc/apache2/sites-available
RUN a2ensite vhost.conf
RUN a2enmod rewrite

COPY run.sh /usr/local/bin/run-app
RUN chmod +x /usr/local/bin/run-app
CMD ["run-app"]
