# Use Ubuntu base image for better timezone support
FROM ubuntu:22.04

# Set timezone environment variable
ENV TZ=UTC
ENV DEBIAN_FRONTEND=noninteractive

# Install PHP and required packages including timezone data
RUN apt-get update && \
    apt-get install -y \
    php8.1 \
    php8.1-cli \
    php8.1-pdo \
    php8.1-pgsql \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-curl \
    php8.1-zip \
    php8.1-intl \
    php8.1-gd \
    curl \
    tar \
    tzdata && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Configure timezone explicitly
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN echo "date.timezone = UTC" >> /etc/php/8.1/cli/php.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Copy application code
COPY . .

# Create directories and set permissions
RUN mkdir -p tmp logs && chmod -R 775 tmp logs

# Expose port
EXPOSE $PORT

# Use PHP built-in server
CMD php8.1 bin/cake.php server -H 0.0.0.0 -p $PORT