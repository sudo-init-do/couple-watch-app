# Stage 1: Base (PHP + Extensions)
FROM php:8.2-fpm as base
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip



# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Stage 2: Build Frontend Assets (for Prod)
FROM node:20 as frontend-build
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 3: Build Backend Dependencies (for Prod)
FROM composer:2 as backend-build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# Stage 4: Production Image
FROM base as prod
# Copy backend dependencies
COPY --from=backend-build /app/vendor /var/www/html/vendor
# Copy frontend assets
COPY --from=frontend-build /app/public/build /var/www/html/public/build
# Copy application code
COPY . /var/www/html
# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
