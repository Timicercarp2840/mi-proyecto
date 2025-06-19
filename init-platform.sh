#!/bin/bash

echo "🚀 Inicializando la plataforma educativa con datos de ejemplo..."

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders
echo "🌱 Poblando base de datos con datos de ejemplo..."
php artisan db:seed --class=DesafioSeeder

# Asignar contenido a usuarios existentes
echo "👥 Asignando contenido a usuarios existentes..."
php artisan usuarios:asignar-contenido --solo-nuevos

echo "✅ ¡Inicialización completada!"
echo ""
echo "🎯 Puedes acceder a:"
echo "   - Panel de administración: /admin/desafios"
echo "   - Desafío Libre: menú desplegable en navegación"
echo "   - Perfil Gamer: menú de usuario"
echo ""
echo "🌙 El modo oscuro está disponible en todos los layouts"
