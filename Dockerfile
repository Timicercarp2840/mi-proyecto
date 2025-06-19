# Stage para instalar dependencias PHP
FROM composer:latest AS composer-stage

WORKDIR /app

# Copiar archivos de composer
COPY composer.json composer.lock ./

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Multi-stage build para el frontend
FROM node:18-alpine AS node-builder

WORKDIR /app

# Copiar archivos de configuración
COPY package*.json ./
COPY vite.config.js tailwind.config.js postcss.config.js jsconfig.json ./

# Instalar dependencias de Node
RUN npm ci --silent

# Copiar archivos fuente
COPY resources/ ./resources/
COPY public/ ./public/

# Copiar vendor desde el stage de composer (incluyendo ziggy)
COPY --from=composer-stage /app/vendor/ ./vendor/

# Build de assets
RUN npm run build

# Imagen principal de PHP
FROM php:8.2-apache

# Instalar extensiones de PHP necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql pgsql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar el resto de la aplicación
COPY . .

# Copiar dependencias de PHP desde el stage anterior
COPY --from=composer-stage /app/vendor/ ./vendor/

# Copiar assets compilados desde el stage anterior
COPY --from=node-builder /app/public/build ./public/build

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Configurar Apache
RUN a2enmod rewrite

# Copiar configuración personalizada de Apache
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Crear script de inicio
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Exponer puerto
EXPOSE 80

# Comando de inicio
CMD ["/usr/local/bin/start.sh"]
