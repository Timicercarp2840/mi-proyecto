@echo off
echo ========================================
echo SABLE - Sistema de Gestion de Tareas
echo ========================================
echo.

if "%1"=="install" (
    echo Instalando dependencias...
    call composer install
    call npm install
    echo Configurando base de datos...
    call php artisan migrate:fresh --seed
    call php artisan db:seed --class=AdminUserSeeder
    echo Compilando assets...
    call npm run build
    echo.
    echo ✅ Instalacion completada!
    echo Usuario admin: admin@sable.com / admin123
    echo Usuario estudiante: estudiante@sable.com / estudiante123
    goto end
)

if "%1"=="dev" (
    echo Iniciando modo desarrollo...
    start cmd /k "cd /d %~dp0 && npm run dev"
    call php artisan serve
    goto end
)

if "%1"=="build" (
    echo Compilando para produccion...
    call npm run build
    echo ✅ Assets compilados!
    goto end
)

if "%1"=="fresh" (
    echo Reiniciando base de datos...
    call php artisan migrate:fresh --seed
    call php artisan db:seed --class=AdminUserSeeder
    echo ✅ Base de datos reiniciada!
    goto end
)

if "%1"=="test" (
    echo Ejecutando tests...
    call php artisan test
    goto end
)

if "%1"=="clear" (
    echo Limpiando cache...
    call php artisan cache:clear
    call php artisan config:clear
    call php artisan view:clear
    echo ✅ Cache limpiado!
    goto end
)

echo Uso: sable.bat [comando]
echo.
echo Comandos disponibles:
echo   install  - Instalar dependencias y configurar el proyecto
echo   dev      - Iniciar modo desarrollo (Vite + Laravel serve)
echo   build    - Compilar assets para produccion
echo   fresh    - Reiniciar base de datos con seeders
echo   test     - Ejecutar tests
echo   clear    - Limpiar cache de Laravel
echo.

:end
