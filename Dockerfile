# Stage 1: build assets
FROM node:20 AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build || true

# Stage 2: PHP + Apache
FROM php:8.2-apache

# System deps + PHP extensions (pg for Supabase)
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql gd bcmath zip mbstring

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy app
WORKDIR /var/www/html
COPY . .

# Copy built frontend (jika ada) dari builder -> ke public/build atau public
COPY --from=node_builder /app/dist ./public/build || true
COPY --from=node_builder /app/public ./public || true

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist || true

# Build/compile assets fallback (cukup aman jika sudah dibuild di stage node)
RUN if [ -f package.json ]; then npm ci && npm run build || true; fi

# Permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
