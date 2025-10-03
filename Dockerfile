# Gunakan PHP + Composer
FROM php:8.2-fpm

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Buat direktori kerja
WORKDIR /var/www/html

# Copy file project
COPY . .

# Install dependencies PHP & JS
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Permission storage & bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8080
