FROM php:8.2-cli-bullseye
RUN apt-get update \
  && apt-get install -y fonts-ipaexfont  imagemagick libmagickwand-dev libzip-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && pecl install imagick \
  && docker-php-ext-enable imagick zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
