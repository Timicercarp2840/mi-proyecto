#!/bin/bash

echo "🐳 Construyendo imagen Docker..."

# Construir la imagen
docker build -t plataforma-educativa .

echo "✅ Imagen construida exitosamente!"
echo "💡 Para ejecutar usa: docker-compose up"
