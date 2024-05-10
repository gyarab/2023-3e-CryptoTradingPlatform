# Stage 1: Composer
FROM composer:latest AS composer

# Set working directory
WORKDIR /cryptoTradingPlatform/app

# Copy the project files
COPY . .

# Install composer dependencies
RUN COMPOSER_VENDOR_DIR="/cryptoTradingPlatform/vendor" composer install --dev --no-progress --no-suggest --no-interaction --prefer-dist --optimize-autoloader

# Stage 2: Build assets with Node.js
FROM node:16 AS builder

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install npm dependencies
RUN npm install

# Copy the rest of the application code
COPY . .

# Build assets
RUN npm run build

# Stage 3: Final PHP image
FROM php:8.1

# Install system dependencies
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql sockets zip

# Set working directory
WORKDIR /app

COPY --from=composer /cryptoTradingPlatform /app
COPY --from=builder /app/public /app/public
COPY artisan /app
COPY bootstrap /app/bootstrap
COPY config /app/config
COPY database /app/database
COPY public /app/public
COPY resources /app/resources
COPY routes /app/routes
COPY storage /app/storage
COPY tests /app/tests


CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000

# Expose port (if needed)
# EXPOSE 8000

# Run your application
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
