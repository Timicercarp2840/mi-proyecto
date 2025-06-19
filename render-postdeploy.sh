#!/bin/bash

# Script de post-deploy para Render
echo "🔄 Ejecutando tareas de post-deploy..."

# Crear enlaces de storage si no existen
echo "🔗 Creando enlaces de storage..."
php artisan storage:link --force

# Verificar que la base de datos esté funcionando
echo "✅ Verificando conexión a base de datos..."
php artisan migrate:status

# Limpiar cachés después del deploy
echo "🧹 Limpiando cachés..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recrear cachés optimizados
echo "⚡ Recreando cachés optimizados..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Post-deploy completado!"
