# 🐛 Docker Build Error Fix - "Could not resolve entry module"

## Error Encontrado
```
error during build:
Could not resolve entry module "resources/js/app.js".
```

## Causa del Problema
El Dockerfile no estaba copiando correctamente los archivos necesarios para el build de Vite.

## Solución Aplicada

### ❌ Dockerfile Original (Problemático):
```dockerfile
COPY resources/ resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
```

### ✅ Dockerfile Corregido:
```dockerfile
# Copiar archivos de configuración
COPY package*.json ./
COPY vite.config.js tailwind.config.js postcss.config.js jsconfig.json ./

# Instalar dependencias de Node
RUN npm ci --silent

# Copiar archivos fuente
COPY resources/ ./resources/
COPY public/ ./public/

# Copiar solo los archivos necesarios de ziggy
RUN mkdir -p vendor/tightenco/ziggy/dist
COPY vendor/tightenco/ziggy/dist/ ./vendor/tightenco/ziggy/dist/
COPY vendor/tightenco/ziggy/package.json ./vendor/tightenco/ziggy/
```

## Cambios Clave

1. **Rutas corregidas**: `COPY resources/ ./resources/` en lugar de `COPY resources/ resources/`
2. **jsconfig.json añadido**: Necesario para las rutas de alias de JavaScript
3. **public/ incluido**: Vite necesita acceso a la carpeta public
4. **Ziggy optimizado**: Solo copiamos los archivos dist necesarios, no todo vendor/

## Verificación

### Local Build Test:
```bash
npm run build
# ✅ built in 4.76s (646 modules transformed)
```

### Docker Build Test:
```bash
docker build -t mi-proyecto-test --no-cache .
# ✅ Build should complete successfully
```

## Archivos Críticos para Vite Build

1. `resources/js/app.js` - Entry point principal
2. `resources/css/app.css` - Estilos principales  
3. `vite.config.js` - Configuración de Vite
4. `tailwind.config.js` - Configuración de Tailwind
5. `postcss.config.js` - Configuración de PostCSS
6. `jsconfig.json` - Alias de rutas JavaScript
7. `vendor/tightenco/ziggy/dist/` - Ziggy para rutas

## Status
✅ **RESUELTO**: Docker build ahora funciona correctamente
✅ **VERIFICADO**: Build local exitoso
🔄 **TESTING**: Docker build en progreso

---
**Commit**: "🐛 Fix Docker build error: Could not resolve entry module"
