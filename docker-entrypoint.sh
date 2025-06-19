#!/bin/bash

# Wait for database to be ready
echo "Waiting for database..."
while ! nc -z $DB_HOST $DB_PORT; do
  sleep 1
done
echo "Database is ready!"

# Reset database completely (fresh migrations + seed)
echo "Resetting database..."
php artisan migrate:fresh --force

# Seed database with all seeders
echo "Seeding database..."
php artisan db:seed --force

# Generate Ziggy routes
echo "Generating Ziggy routes..."
php artisan ziggy:generate

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache..."
# Start Apache
exec apache2-foreground
