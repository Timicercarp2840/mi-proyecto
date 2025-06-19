#!/usr/bin/env bash
set -o errexit

# Install Node dependencies and build assets
npm ci
npm run build

# Install PHP dependencies (Composer ya está disponible en Render)
composer install --optimize-autoloader --no-dev

# Cache Laravel configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed --class=ProductionSeeder --force
