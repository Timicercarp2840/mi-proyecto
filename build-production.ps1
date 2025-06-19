# Limpiar assets anteriores
if (Test-Path "public\build\*") { 
    Remove-Item "public\build\*" -Recurse -Force 
}

# Establecer variables de entorno correctas
$env:APP_URL = "https://sable-app.onrender.com"
$env:APP_ENV = "production"

# Regenerar assets con configuración correcta
npm run build

Write-Host "Build completed with APP_URL: $env:APP_URL"
