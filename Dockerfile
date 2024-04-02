# Use the official PHP image as a base
FROM php:8.3-cli

# Set the working directory inside the container
WORKDIR /var/www

# Copy the application files to the container
COPY . .

# Copy the .env file
COPY .env.example .env

# Install PHP extensions and other dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
RUN composer install

# Expose port 8000 to the outside world (if needed)
EXPOSE 8000

# Start the Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]