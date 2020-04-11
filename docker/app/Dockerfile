FROM php:7.2-fpm-alpine3.8

RUN apk --update --virtual build-deps add \
        autoconf \
        make \
        gcc \
        g++ \
        libtool \
        icu-dev \
        curl-dev \
        freetype-dev \
        imagemagick-dev \
        pcre-dev \
        postgresql-dev \
        libmcrypt-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libxml2-dev && \
    apk add \
        git \
        curl \
        bash \
        bash-completion \
        icu \
        imagemagick \
        pcre \
        freetype \
        libmcrypt \
        libintl \
        libjpeg-turbo \
        libpng \
        libltdl \
        libxml2 \
        mysql-client \
        nodejs-npm \
        postgresql \
        libreoffice && \
    pecl install \
        apcu \
        imagick \
        mcrypt-1.0.0 && \
    docker-php-ext-configure gd \
        --with-gd \
        --with-freetype-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-configure bcmath && \
    docker-php-ext-configure calendar && \
    docker-php-ext-install \
        soap \
        zip \
        curl \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        calendar \
        pdo_pgsql && \
    apk del \
        build-deps

RUN apk --no-cache add msttcorefonts-installer fontconfig && \
    update-ms-fonts && \
    fc-cache -f

RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/pecl-apcu.ini \
 && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/pecl-imagick.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www

RUN composer create-project --prefer-dist yiisoft/yii2-app-advanced yii-application
RUN composer global require "fxp/composer-asset-plugin:~1.3"
RUN npm install -g less