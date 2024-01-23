FROM node:18 AS node
FROM php:8.2-apache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ARG UNAME=www-data
ARG UGROUP=www-data
ARG UID=1000
ARG GID=1000
RUN usermod  --uid $UID $UNAME
RUN groupmod --gid $GID $UGROUP

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN apt-get update && apt-get -y install \
    vim \
    cron \
    git \
    zlib1g-dev \
    zip \
    libzip-dev \
    libonig-dev \
    redis-server \
    openssh-client \
    mariadb-client \
    apt-transport-https \
    git \
    zlib1g-dev \
    zip \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libsodium-dev \
    libicu-dev \
    libxml2-dev \
    libxslt-dev \
    libyaml-dev

RUN pecl install yaml && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini && docker-php-ext-enable yaml
RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-install zip
RUN docker-php-ext-install mbstring
RUN docker-php-ext-enable opcache
RUN docker-php-ext-install mysqli pdo pdo_mysql 

RUN docker-php-ext-install xsl soap
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sodium

RUN a2enmod rewrite

ADD ./apache.conf /etc/apache2/sites-available/000-default.conf
RUN ln -sf /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN chown -R www-data:www-data /var/www

USER www-data
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN echo 'PATH=$PATH:/var/www/.symfony5/bin/' >> /var/www/.bashrc

USER root
