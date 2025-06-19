#!/bin/bash

echo "🧪 ========== VALIDACIÓN DE USUARIOS POR DEFECTO =========="
echo ""

# Verificar que Laravel está funcionando
echo "🔍 Verificando Laravel..."
php artisan --version || {
    echo "❌ Error: Laravel no está funcionando"
    exit 1
}

echo "✅ Laravel funcionando correctamente"
echo ""

# Limpiar cache
echo "🧹 Limpiando cache..."
php artisan config:clear
php artisan cache:clear
echo "✅ Cache limpiado"
echo ""

# Ejecutar migraciones fresh con seed
echo "🗄️ Reiniciando base de datos..."
php artisan migrate:fresh --seed --force
echo "✅ Base de datos reiniciada"
echo ""

# Mostrar usuarios
echo "👥 Mostrando usuarios..."
php artisan usuarios:mostrar
echo ""

# Crear usuarios por defecto (por si acaso)
echo "🔧 Asegurando usuarios por defecto..."
php artisan usuarios:crear-defecto
echo ""

# Verificación final
echo "🎯 ========== VERIFICACIÓN FINAL =========="
php artisan usuarios:mostrar

echo ""
echo "✅ Validación completada!"
echo "💡 Los usuarios por defecto deberían estar disponibles para login"
