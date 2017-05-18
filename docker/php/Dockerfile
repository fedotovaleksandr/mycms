FROM php:7.1-fpm

COPY ./php.ini /usr/local/etc/php/conf.d
COPY ./php.pool.conf /usr/local/etc/php-fpm.d/

RUN apt-get update && apt-get install -y \
    git \
    bower \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
    libpq-dev \
    libxml2-dev \
    xvfb

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install \
    gd \
    gettext \
    intl \
    mcrypt \
    opcache \
    pdo_mysql \
    soap \
    zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

RUN mkdir ~/.ssh && ssh-keyscan -H github.com >> ~/.ssh/known_hosts

RUN mkdir /var/log/mycms
RUN chown -R www-data:www-data /var/log/mycms

RUN usermod -u 1000 www-data

WORKDIR /var/www/mycms

CMD cp ~/_ssh/id_rsa ~/.ssh/id_rsa && chmod 0600 ~/.ssh/id_rsa && php-fpm

EXPOSE 9000
