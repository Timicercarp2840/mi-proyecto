#!/bin/bash
set -e

# Wait for database to be ready
echo "Waiting for database..."
while ! nc -z $DB_HOST $DB_PORT; do
  sleep 1
done
echo "Database is ready!"

# Reset database completely (fresh migrations + seed)
echo "Resetting database..."
php artisan migrate:fresh --force
echo "Migrations completed!"

# Check if tables exist
echo "Checking tables..."
php artisan tinker --execute="Schema::hasTable('insignias') ? print('Insignias table exists') : print('Insignias table MISSING');"

# Seed database with all seeders
echo "Seeding database..."
php artisan db:seed --force
echo "Seeding completed!"

# Generate Ziggy routes
echo "Generating Ziggy routes..."
php artisan ziggy:generate || echo "Ziggy generation failed, continuing..."

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache..."
# Start Apache
exec apache2-foreground
