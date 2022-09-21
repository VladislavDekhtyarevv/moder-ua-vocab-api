FROM php:8.1-apache

MAINTAINER Vladislav Dehtarev <dehtarev.vladislav@gmail.com>

ARG HOST_UID=1000

VOLUME ["/var/www/html"]

ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update \
	&& apt-get install -y libmcrypt-dev \
	&& rm -rf /var/lib/apt/lists/*
RUN apt-get update -y \
    && apt-get install -y \
       libxml2-dev \
    && apt-get clean -y \
    && docker-php-ext-install soap
RUN apt-get update && apt-get install -my wget gnupg
RUN apt-get update && apt-get install -y apt-utils
RUN apt-get update && apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        libpq-dev \
        libpcre3-dev \
        git \
        nano \
        zip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libzip-dev \
        supervisor \
        default-mysql-client \
        cron \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install intl zip pdo_mysql \
    && docker-php-ext-install exif \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install grpc
RUN pecl install protobuf-3.19.4

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

# Install google-chrome-stable
RUN apt-get install -y wget && \
    wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub |  apt-key add - && \
    sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list' && \
    apt-get update && apt-get install -y google-chrome-stable && \
    apt-get install -y xvfb

# Install Xdebug
#RUN yes | pecl install xdebug \
#    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" \
#    > /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

COPY ./.bashrc /root/.bashrc
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf
COPY ./php.ini /usr/local/etc/php/

RUN echo "LogFormat \"%a %l %u %t \\\"%r\\\" %>s %O \\\"%{User-Agent}i\\\"\" mainlog" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite remoteip

# Install composer
RUN set -x && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Setup permissions for user `www-data`
RUN usermod -u ${HOST_UID} www-data && groupmod -g ${HOST_UID} www-data && chsh -s /bin/bash www-data

# Setup cron
ADD ./crontab /etc/cron.d/cron-jobs
RUN chmod 0644 /etc/cron.d/cron-jobs && touch /var/log/cron.log

# Setup supervisor
RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord"]
