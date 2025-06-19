#!/bin/bash

# Script de simulación de deploy para pruebas locales
echo "🧪 Simulando deploy de Render localmente..."

# Verificar que el archivo .env existe
if [ ! -f .env ]; then
    echo "❌ Archivo .env no encontrado. Copiando desde .env.example..."
    cp .env.example .env
fi

# Simular el proceso de build
echo "🔨 Ejecutando proceso de build..."
chmod +x render-build.sh
./render-build.sh

# Verificar que la aplicación funciona
echo "🔍 Verificando aplicación..."
php artisan about

echo "✅ Simulación de deploy completada!"
echo "💡 Para probar localmente ejecuta: php artisan serve"
