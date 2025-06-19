@echo off
echo 🧪 Simulando deploy de Render en Windows...

REM Verificar que el archivo .env existe
if not exist .env (
    echo ❌ Archivo .env no encontrado. Copiando desde .env.example...
    copy .env.example .env
)

REM Instalar dependencias
echo 📦 Instalando dependencias de PHP...
composer install --no-dev --optimize-autoloader --no-interaction

echo 📦 Instalando dependencias de Node.js...
npm ci --silent

REM Compilar assets
echo 🔨 Compilando assets...
npm run build

REM Configurar aplicación
echo 🔑 Configurando aplicación...
php artisan key:generate --force

REM Limpiar configuración
echo 🧹 Limpiando configuración...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

REM Reiniciar base de datos
echo 🗄️ Reiniciando base de datos...
php artisan migrate:fresh --force --seed

REM Asignar contenido
echo 👥 Asignando contenido a usuarios...
php artisan asignar:contenido-existente

REM Optimizar para producción
echo ⚡ Optimizando para producción...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ✅ Simulación de deploy completada!
echo 💡 Para probar localmente ejecuta: php artisan serve
pause
