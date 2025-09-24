FROM alpine:3.18

# Install PHP and required extensions
RUN apk add --no-cache \
    php81 \
    php81-cli \
    php81-pdo \
    php81-pdo_pgsql \
    php81-mbstring \
    php81-xml \
    php81-curl \
    php81-zip \
    php81-intl \
    php81-gd \
    php81-json \
    php81-openssl \
    php81-ctype \
    php81-tokenizer \
    curl \
    && ln -sf /usr/bin/php81 /usr/bin/php

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
RUN mkdir -p tmp logs \
    && chmod -R 775 tmp logs

# Expose port
EXPOSE $PORT

# Use PHP built-in server
CMD ["sh", "-c", "php bin/cake.php server -H 0.0.0.0 -p $PORT"]