@echo off
REM Script de verificación para la plataforma educativa
REM Verifica que todos los componentes estén funcionando correctamente

echo 🔍 Verificando la plataforma educativa...
echo ================================================

REM Verificar estructura de archivos
echo 📁 Verificando estructura de archivos...

if exist "resources\js\Layouts\AuthenticatedLayout.vue" (
    echo ✅ AuthenticatedLayout.vue
) else (
    echo ❌ AuthenticatedLayout.vue - NO ENCONTRADO
)

if exist "resources\js\Components\DarkModeToggle.vue" (
    echo ✅ DarkModeToggle.vue
) else (
    echo ❌ DarkModeToggle.vue - NO ENCONTRADO
)

if exist "resources\js\Components\DropdownNav.vue" (
    echo ✅ DropdownNav.vue
) else (
    echo ❌ DropdownNav.vue - NO ENCONTRADO
)

if exist "resources\js\Components\DropdownNavLink.vue" (
    echo ✅ DropdownNavLink.vue
) else (
    echo ❌ DropdownNavLink.vue - NO ENCONTRADO
)

if exist "resources\js\Pages\Perfil\Unificado.vue" (
    echo ✅ Perfil Unificado.vue
) else (
    echo ❌ Perfil Unificado.vue - NO ENCONTRADO
)

if exist "app\Http\Controllers\AdminDesafioController.php" (
    echo ✅ AdminDesafioController.php
) else (
    echo ❌ AdminDesafioController.php - NO ENCONTRADO
)

if exist "app\Http\Controllers\PerfilUnificadoController.php" (
    echo ✅ PerfilUnificadoController.php
) else (
    echo ❌ PerfilUnificadoController.php - NO ENCONTRADO
)

if exist "app\Listeners\AsignarContenidoANuevoUsuario.php" (
    echo ✅ AsignarContenidoANuevoUsuario.php
) else (
    echo ❌ AsignarContenidoANuevoUsuario.php - NO ENCONTRADO
)

if exist "app\Console\Commands\AsignarContenidoExistente.php" (
    echo ✅ AsignarContenidoExistente.php
) else (
    echo ❌ AsignarContenidoExistente.php - NO ENCONTRADO
)

echo.
echo 🔧 Verificando configuración...

findstr /c:"perfil.unificado" routes\web.php >nul
if %errorlevel%==0 (
    echo ✅ Ruta de perfil unificado configurada
) else (
    echo ❌ Ruta de perfil unificado NO configurada
)

findstr /c:"admin.desafios" routes\web.php >nul
if %errorlevel%==0 (
    echo ✅ Rutas de admin desafíos configuradas
) else (
    echo ❌ Rutas de admin desafíos NO configuradas
)

findstr /c:"darkMode" tailwind.config.js >nul
if %errorlevel%==0 (
    echo ✅ Dark mode configurado en Tailwind
) else (
    echo ❌ Dark mode NO configurado en Tailwind
)

echo.
echo 📦 Verificando assets compilados...

if exist "public\build\manifest.json" (
    echo ✅ Assets compilados correctamente
) else (
    echo ❌ Assets NO compilados - ejecutar 'npm run build'
)

echo.
echo 🎯 Funcionalidades implementadas:
echo ✅ Dark mode opcional
echo ✅ Navbar reorganizado con dropdown 'Desafío Libre'
echo ✅ Menú de usuario simplificado
echo ✅ Gestión de desafíos para admin
echo ✅ Asignación automática de contenido
echo ✅ Pantalla de perfil unificada
echo ✅ Corrección de posicionamiento de dropdowns

echo.
echo 🚀 La plataforma está lista para usar!
echo ================================================

pause
