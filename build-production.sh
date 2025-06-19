#!/bin/bash

# Limpiar assets anteriores
rm -rf public/build/*

# Establecer variables de entorno correctas
export APP_URL="https://sable-app.onrender.com"
export APP_ENV="production"

# Regenerar assets con configuración correcta
npm run build

echo "Build completed with APP_URL: $APP_URL"
