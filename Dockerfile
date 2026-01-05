FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first
COPY composer.json composer.lock* ./

# Install composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy package files
COPY package.json package-lock.json* ./

# Install npm dependencies
RUN npm install

# Copy the rest of the application
COPY . /var/www

# Run composer scripts
RUN composer dump-autoload --optimize

# Build assets
RUN npm run build

# Create entrypoint script
RUN echo '#!/bin/bash\n\
if [ ! -f ".env" ]; then\n\
    cp .env.example .env 2>/dev/null || true\n\
fi\n\
php artisan key:generate --force 2>/dev/null || true\n\
php artisan serve --host=0.0.0.0 --port=8000\n\
' > /entrypoint.sh && chmod +x /entrypoint.sh

# Expose port 8000
EXPOSE 8000

# Start Laravel development server
CMD ["/entrypoint.sh"]
