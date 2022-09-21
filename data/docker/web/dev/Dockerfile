FROM php:8.0-apache
# FROM --platform=linux/amd64 php:8.0-apache
MAINTAINER Vladislav Dehtarev <dehtarev.vladislav@gmail.com>
ARG HOST_UID=1000
VOLUME ["/var/www/html"]
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && apt-get install -y  \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    zlib1g-dev \
    zip \
    --no-install-recommends \
    && docker-php-ext-enable opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd \
    && docker-php-ext-install zip \
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/*
# Install pecl
RUN pecl install grpc
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN pecl -v install redis && docker-php-ext-enable redis
RUN pecl -v install rar && docker-php-ext-enable rar
# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get update && apt-get install -y nodejs
COPY ./.bashrc /root/.bashrc
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf
COPY ./php.ini /usr/local/etc/php/
RUN echo "LogFormat \"%a %l %u %t \\\"%r\\\" %>s %O \\\"%{User-Agent}i\\\"\" mainlog" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite remoteip
# Install composer
RUN #set -x && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Setup permissions for user `www-data`
RUN usermod -u ${HOST_UID} www-data && groupmod -g ${HOST_UID} www-data && chsh -s /bin/bash www-data
EXPOSE 80
