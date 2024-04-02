# Use the official PHP image as a base
FROM php:8.3-cli

# Set the working directory inside the container
WORKDIR /var/www

# Copy the application files to the container
COPY . /var/www

# Install dependencies and set up the application
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install \
    && php artisan key:generate \
    && php artisan migrate --force \
    && php artisan db:seed

# Expose port 8000 to the outside world
EXPOSE 8000

# Start the Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
