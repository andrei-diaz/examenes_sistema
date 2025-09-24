# Use the built-in PHP development server instead of Apache
FROM debian:bullseye-slim

# Install PHP and required extensions
RUN apt-get update && apt-get install -y \
    php8.1-cli \
    php8.1-pgsql \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-curl \
    php8.1-zip \
    php8.1-intl \
    php8.1-gd \
    curl \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application code
COPY . .

# Create directories and set permissions
RUN mkdir -p tmp logs \
    && chmod -R 775 tmp logs

# Expose port
EXPOSE $PORT

# Use PHP built-in server
CMD php bin/cake.php server -H 0.0.0.0 -p $PORT