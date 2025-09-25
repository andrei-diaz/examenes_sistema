# Use a more reliable base image
FROM registry.access.redhat.com/ubi8/ubi-minimal:latest

# Set timezone environment variable
ENV TZ=UTC

# Install PHP and required packages including timezone data
RUN microdnf install -y php php-cli php-pdo php-pgsql php-mbstring php-xml php-curl php-zip php-intl php-gd php-json curl tar tzdata && \
    microdnf clean all

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
CMD php bin/cake.php server -H 0.0.0.0 -p $PORT