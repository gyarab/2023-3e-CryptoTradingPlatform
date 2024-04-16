# Use the official PHP image
FROM php:8.1

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /cryptoTradingPlatform

# Copy the composer files
COPY composer.json composer.lock ./

# Install Composer dependencies in a custom directory
RUN COMPOSER_VENDOR_DIR="/cryptoTradingPlatform/vendor" composer install --no-scripts --no-autoloader

# Copy the rest of the application files
COPY . .

# Update paths to autoload files
RUN sed -i 's/vendor\//..\/vendor\//' public/index.php
RUN sed -i 's/vendor\//..\/vendor\//' artisan
RUN sed -i 's/vendor\//..\/vendor\//' phpunit.xml

# Install Composer dependencies (including autoload files)
RUN composer dump-autoload --optimize

# Expose port if needed
# EXPOSE 8000

# Command to run the application
# CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
