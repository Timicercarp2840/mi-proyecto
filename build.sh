#!/usr/bin/env bash
# exit on error
set -o errexit

# Update package list and install PHP and Composer
apt-get update
apt-get install -y php php-cli php-pgsql php-mbstring php-xml php-curl composer

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node.js dependencies and build assets
npm ci
npm run build

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Seed production data
php artisan db:seed --class=ProductionSeeder --force
