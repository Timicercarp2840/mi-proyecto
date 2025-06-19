@echo off
echo 🐳 Construyendo imagen Docker...

REM Construir la imagen
docker build -t plataforma-educativa .

echo ✅ Imagen construida exitosamente!
echo 💡 Para ejecutar usa: docker-compose up
pause
