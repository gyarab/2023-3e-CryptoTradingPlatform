From php:8.1.6 as php

# Install composer:
#RUN composer install
#RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer -O - -q | php -- --quiet
#RUN mv composer.phar /usr/local/bin/composer

#RUN apt-get update -y
#RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
#RUN docker-php-ext-install pdo pdo_mysql bcmath

#WORKDIR /cryptoTradingPlatform/app
#COPY . .
#RUN COMPOSER_VENDOR_DIR="/cryptoTradingPlatform/vendor" composer install