# DOCKER-VERSION        1.3.2

# Build UI assets
FROM node:10-alpine as assets
RUN apk add git
RUN npm install -g grunt-cli
RUN mkdir -p /work/public/js /work/public/css templates/layout templates/blog
WORKDIR /work
COPY Gruntfile.js Gruntfile.js
COPY package.json package.json
COPY package-lock.json package-lock.json
COPY public/css/*.* public/css/
COPY public/js/*.* public/js/
COPY templates/layout/*.phtml templates/layout/
COPY src/Blog/templates/*.phtml templates/blog/
RUN npm install
RUN cp node_modules/bootstrap/dist/js/bootstrap.js public/js/
RUN cp node_modules/jquery/dist/jquery.js public/js/
RUN cp node_modules/autocomplete.js/dist/autocomplete.jquery.js public/js/
RUN grunt

# Build the PHP container
FROM mwop/phly-docker-php-swoole:7.4-alpine

# System dependencies
RUN echo 'http://dl-cdn.alpinelinux.org/alpine/v3.6/community' >> /etc/apk/repositories
RUN apk update && \
  apk add --no-cache \
    bzip2-dev \
    icu-dev \
    libxml2-dev \
    libxslt-dev \
    libzip-dev \
    'tidyhtml-dev==5.2.0-r1' \
    php7-bcmath \
    php7-bz2 \
    php7-curl \
    php7-intl \
    php7-opcache \
    php7-openssl \
    php7-pcntl \
    php7-xsl \
    php7-zip

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) tidy

# PHP configuration
COPY etc/php/mwop.ini /usr/local/etc/php/conf.d/999-mwop.ini

# Overwrite entrypoint
COPY etc/bin/php-entrypoint /usr/local/bin/entrypoint

# Crontab
COPY etc/cron.d/mwopnet /etc/cron.d/

# Public directory/static assets
COPY public /var/www/public
COPY --from=assets /work/public/css/*.css /var/www/public/css/
COPY --from=assets /work/public/js/*.* /var/www/public/js/

# Project files
COPY bin /var/www/bin
COPY composer.json /var/www/
COPY composer.lock /var/www/
COPY templates /var/www/templates
COPY config /var/www/config
COPY src /var/www/src
COPY data /var/www/data

# Reset "local"/development config files
RUN rm -f /var/www/config/development.config.php && \
  rm -f /var/www/config/autoload/*.local.php && \
  mv /var/www/config/autoload/local.php.dist /var/www/config/autoload/local.php

# Build project
WORKDIR /var/www
RUN composer install --no-ansi --no-dev --no-interaction --no-scripts --optimize-autoloader && \
  /usr/bin/env php bin/mwop.net.php asset:use-dist-templates && \
  composer clean:build-assets
