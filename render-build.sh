#!/bin/bash

# Script de build para Render
echo "🚀 Iniciando proceso de build para Render..."

# Configurar timezone
export TZ=America/Lima

# Instalar dependencias de Composer
echo "📦 Instalando dependencias de PHP..."
composer install --no-dev --optimize-autoloader --no-interaction

# Instalar dependencias de Node.js
echo "📦 Instalando dependencias de Node.js..."
npm ci --silent

# Compilar assets
echo "🔨 Compilando assets..."
npm run build

# Generar clave de aplicación si no existe
echo "🔑 Configurando aplicación..."
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Limpiar configuración antes de migraciones
echo "🧹 Limpiando configuración..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Verificar conexión a la base de datos
echo "🔍 Verificando conexión a base de datos..."
php artisan migrate:status || echo "⚠️ Base de datos no disponible, continuando..."

# Reiniciar completamente la base de datos
echo "🗄️ Reiniciando base de datos completamente..."
php artisan migrate:fresh --force --seed

# Asignar contenido a usuarios existentes (por si hay usuarios después del seeding)
echo "👥 Asignando contenido a usuarios..."
php artisan usuarios:asignar-contenido --solo-nuevos || echo "⚠️ Comando de asignación no disponible"

# Crear enlaces de storage
echo "🔗 Creando enlaces de storage..."
php artisan storage:link --force

# Optimizar para producción
echo "⚡ Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completado exitosamente!"
echo "🌐 La aplicación está lista para servir en el puerto $PORT"
