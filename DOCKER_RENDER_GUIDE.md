# 🐳 Deploy con Docker en Render

## Ventajas de usar Docker en Render

✅ **Entorno consistente** - Mismo ambiente en desarrollo y producción  
✅ **Build más rápido** - Cache de capas de Docker  
✅ **Dependencias controladas** - Todo empaquetado en la imagen  
✅ **Escalabilidad** - Fácil replicación y escalado  
✅ **Aislamiento** - Sin conflictos de dependencias  

## 📁 Archivos Docker Creados

### Core Docker Files
- **`Dockerfile`** - Imagen principal con Apache y PHP 8.2
- **`docker/apache.conf`** - Configuración de Apache 
- **`docker/start.sh`** - Script de inicio con reinicio de BD
- **`.dockerignore`** - Archivos excluidos del build

### Development
- **`docker-compose.yml`** - Stack completo para desarrollo local
- **`docker-build.sh/bat`** - Scripts para construir imagen

### Render Configuration  
- **`render.yaml`** - Configuración automática con Docker

## 🚀 Deploy en Render con Docker

### Paso 1: Configurar render.yaml

El archivo `render.yaml` ya está configurado para:
- ✅ **Web Service** con Docker
- ✅ **PostgreSQL Database** automática
- ✅ **Variables de entorno** enlazadas automáticamente
- ✅ **Región** optimizada

### Paso 2: Deploy Automático

1. **Push** tu código a GitHub/GitLab
2. **Conectar** repositorio en Render
3. **Render detecta** automáticamente `render.yaml`
4. **Creates** base de datos PostgreSQL
5. **Builds** imagen Docker
6. **Deploys** aplicación

### Paso 3: Variables de Entorno (Automáticas)

Con `render.yaml`, Render configura automáticamente:
```env
APP_NAME=Plataforma Educativa
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=pgsql
DB_HOST=auto-generated
DB_PORT=auto-generated  
DB_DATABASE=auto-generated
DB_USERNAME=auto-generated
DB_PASSWORD=auto-generated
```

## 🏗️ Multi-Stage Build

### Stage 1: Node.js Builder
```dockerfile
FROM node:18-alpine AS node-builder
# Compila assets (CSS, JS)
```

### Stage 2: PHP Production
```dockerfile  
FROM php:8.2-apache
# Imagen final optimizada con Apache
```

**Resultado**: Imagen final más pequeña y rápida.

## 🔄 Reinicio Automático de BD

### En `docker/start.sh`:
```bash
# Reinicia BD completamente en cada deploy
php artisan migrate:fresh --force --seed
```

**⚠️ ELIMINA todos los datos** y recrea desde cero.

## 🛠️ Desarrollo Local

### Opción 1: Docker Compose (Recomendado)
```bash
# Levantar stack completo
docker-compose up

# Acceder en: http://localhost:8000
```

### Opción 2: Solo imagen Docker
```bash
# Construir imagen
docker build -t plataforma-educativa .

# Ejecutar (necesita BD externa)
docker run -p 8000:80 plataforma-educativa
```

### Opción 3: Scripts helper
```bash
# Windows
docker-build.bat

# Linux/Mac  
./docker-build.sh
```

## 📊 Comparación: Docker vs Script

| Aspecto | Docker | Script Build |
|---------|--------|--------------|
| **Velocidad Build** | ⚡ Más rápido (cache) | 🐌 Más lento |
| **Consistencia** | ✅ 100% consistente | ⚠️ Puede variar |
| **Mantenimiento** | ✅ Fácil | 🔧 Requiere updates |
| **Debugging** | ✅ Logs claros | 😵 Más complejo |
| **Escalabilidad** | ✅ Excelente | ⚠️ Limitada |

## 🎯 Configuración en Render

### Manual Setup (sin render.yaml):
1. **New** → **Web Service**
2. **Environment**: Docker
3. **Dockerfile Path**: `./Dockerfile`
4. **Port**: 80
5. **Auto-Deploy**: Yes

### Database Setup:
1. **New** → **PostgreSQL**  
2. **Name**: `plataforma-educativa-db`
3. **Region**: Same as web service

### Environment Variables:
```env
APP_URL=https://tu-app.onrender.com
APP_KEY=base64:NUEVA_CLAVE_GENERADA
DB_HOST=postgresql-host-from-render
DB_DATABASE=database-name-from-render
DB_USERNAME=user-from-render
DB_PASSWORD=password-from-render
```

## ✅ Verificación Post-Deploy

### Funcionalidades a probar:
- [ ] App carga correctamente
- [ ] Login funciona (admin@admin.com / password)
- [ ] Dark mode funciona
- [ ] Desafío Libre muestra 4 opciones
- [ ] Mi Perfil Completo muestra 4 tabs
- [ ] Base de datos tiene datos de prueba

### Troubleshooting:
```bash
# Ver logs del container
docker logs container-id

# Ejecutar comandos dentro del container
docker exec -it container-id bash
```

## 🚀 Deploy Steps (Resumen)

1. ✅ **Código** push a repositorio
2. ✅ **Render** → New Web Service  
3. ✅ **Docker** environment seleccionado
4. ✅ **render.yaml** detectado automáticamente
5. ✅ **PostgreSQL** creado automáticamente
6. ✅ **Variables** enlazadas automáticamente
7. ✅ **Build** imagen Docker
8. ✅ **Deploy** automático
9. ✅ **BD reiniciada** con datos de prueba

**¡La aplicación estará live en minutos!** 🎉

## 📞 Soporte

- **Logs**: Render Dashboard → Service → Logs
- **Shell**: Render Dashboard → Service → Shell
- **Metrics**: Render Dashboard → Service → Metrics

## 🔗 URLs Finales

- **App**: `https://plataforma-educativa.onrender.com`
- **Admin**: Login con `admin@admin.com` / `password`
- **Estudiante**: Login con `estudiante@estudiante.com` / `password`
