@echo off
echo 🧪 ========== VALIDACIÓN DE USUARIOS POR DEFECTO ==========
echo.

REM Verificar que Laravel está funcionando
echo 🔍 Verificando Laravel...
php artisan --version
if errorlevel 1 (
    echo ❌ Error: Laravel no está funcionando
    exit /b 1
)

echo ✅ Laravel funcionando correctamente
echo.

REM Limpiar cache
echo 🧹 Limpiando cache...
php artisan config:clear
php artisan cache:clear
echo ✅ Cache limpiado
echo.

REM Ejecutar migraciones fresh con seed
echo 🗄️ Reiniciando base de datos...
php artisan migrate:fresh --seed --force
echo ✅ Base de datos reiniciada
echo.

REM Mostrar usuarios
echo 👥 Mostrando usuarios...
php artisan usuarios:mostrar
echo.

REM Crear usuarios por defecto (por si acaso)
echo 🔧 Asegurando usuarios por defecto...
php artisan usuarios:crear-defecto
echo.

REM Verificación final
echo 🎯 ========== VERIFICACIÓN FINAL ==========
php artisan usuarios:mostrar

echo.
echo ✅ Validación completada!
echo 💡 Los usuarios por defecto deberían estar disponibles para login
pause
