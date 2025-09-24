FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev \
    libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd intl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Copy application code
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/tmp \
    && chmod -R 775 /var/www/html/logs

# Configure Apache DocumentRoot to point to webroot
RUN sed -i 's|/var/www/html|/var/www/html/webroot|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/|/var/www/html/webroot/|g' /etc/apache2/apache2.conf

# Configure Apache
RUN a2enmod rewrite

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]