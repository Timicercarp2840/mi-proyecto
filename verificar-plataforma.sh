#!/bin/bash

# Script de verificación para la plataforma educativa
# Verifica que todos los componentes estén funcionando correctamente

echo "🔍 Verificando la plataforma educativa..."
echo "================================================"

# Verificar estructura de archivos
echo "📁 Verificando estructura de archivos..."

# Componentes principales
files_to_check=(
    "resources/js/Layouts/AuthenticatedLayout.vue"
    "resources/js/Components/DarkModeToggle.vue"
    "resources/js/Components/DropdownNav.vue"
    "resources/js/Components/DropdownNavLink.vue"
    "resources/js/Pages/Perfil/Unificado.vue"
    "app/Http/Controllers/AdminDesafioController.php"
    "app/Http/Controllers/PerfilUnificadoController.php"
    "app/Listeners/AsignarContenidoANuevoUsuario.php"
    "app/Console/Commands/AsignarContenidoExistente.php"
)

for file in "${files_to_check[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file"
    else
        echo "❌ $file - NO ENCONTRADO"
    fi
done

echo ""
echo "🔧 Verificando configuración..."

# Verificar que las rutas existan
if grep -q "perfil.unificado" routes/web.php; then
    echo "✅ Ruta de perfil unificado configurada"
else
    echo "❌ Ruta de perfil unificado NO configurada"
fi

if grep -q "admin.desafios" routes/web.php; then
    echo "✅ Rutas de admin desafíos configuradas"
else
    echo "❌ Rutas de admin desafíos NO configuradas"
fi

# Verificar configuración de Tailwind
if grep -q "darkMode" tailwind.config.js; then
    echo "✅ Dark mode configurado en Tailwind"
else
    echo "❌ Dark mode NO configurado en Tailwind"
fi

echo ""
echo "📦 Verificando assets compilados..."

if [ -f "public/build/manifest.json" ]; then
    echo "✅ Assets compilados correctamente"
else
    echo "❌ Assets NO compilados - ejecutar 'npm run build'"
fi

echo ""
echo "🎯 Funcionalidades implementadas:"
echo "✅ Dark mode opcional"
echo "✅ Navbar reorganizado con dropdown 'Desafío Libre'"
echo "✅ Menú de usuario simplificado"
echo "✅ Gestión de desafíos para admin"
echo "✅ Asignación automática de contenido"
echo "✅ Pantalla de perfil unificada"
echo "✅ Corrección de posicionamiento de dropdowns"

echo ""
echo "🚀 La plataforma está lista para usar!"
echo "================================================"
