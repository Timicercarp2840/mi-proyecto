#!/bin/bash

echo "🚀 Iniciando aplicación Laravel en Docker..."

# Esperar a que la base de datos esté disponible
echo "⏳ Esperando conexión a base de datos..."
until php artisan migrate:status 2>/dev/null; do
    echo "Base de datos no disponible, esperando..."
    sleep 2
done

# Generar clave de aplicación si no existe
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generando clave de aplicación..."
    php artisan key:generate --force
fi

# Limpiar cachés
echo "🧹 Limpiando cachés..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Reiniciar base de datos completamente
echo "🗄️ Reiniciando base de datos..."
php artisan migrate:fresh --force --seed

# Asignar contenido a usuarios
echo "👥 Asignando contenido a usuarios..."
php artisan asignar:contenido-existente || echo "Comando no disponible"

# Crear enlaces de storage
echo "🔗 Creando enlaces de storage..."
php artisan storage:link --force

# Optimizar para producción
echo "⚡ Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Aplicación iniciada correctamente!"

# Iniciar Apache
echo "🌐 Iniciando servidor web..."
apache2-foreground
