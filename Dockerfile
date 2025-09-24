FROM webdevops/php-apache:8.1

# Set environment variables
ENV WEB_DOCUMENT_ROOT=/var/www/html/webroot
ENV PHP_DISPLAY_ERRORS=off
ENV PHP_MEMORY_LIMIT=512M

# Install additional PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Copy application
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R application:application /var/www/html \
    && chmod -R 775 /var/www/html/tmp \
    && chmod -R 775 /var/www/html/logs \
    && mkdir -p /var/www/html/tmp /var/www/html/logs

# Create Apache configuration for CakePHP
RUN echo '<Directory "/var/www/html/webroot">\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /opt/docker/etc/httpd/conf.d/cakephp.conf

EXPOSE 80

CMD ["/entrypoint", "supervisord"]