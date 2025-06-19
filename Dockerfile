# Multi-stage build para optimizar el tamaño final
FROM node:18-alpine AS node-builder

WORKDIR /app
COPY package*.json ./
RUN npm ci --silent
COPY resources/ resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
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

# Copiar archivos de dependencias primero (para cache de Docker)
COPY composer.json composer.lock ./

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copiar el resto de la aplicación
COPY . .

# Copiar assets compilados desde el stage anterior
COPY --from=node-builder /app/public/build ./public/build

# Ejecutar scripts post-install de Composer
RUN composer run-script post-autoload-dump

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
