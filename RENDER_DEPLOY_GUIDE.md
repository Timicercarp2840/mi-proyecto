# 🚀 Guía de Deploy en Render.com

## Pre-requisitos
1. ✅ Cuenta en [Render.com](https://render.com)
2. ✅ Repositorio en GitHub/GitLab con el proyecto
3. ✅ Base de datos PostgreSQL en Render

## Paso 1: Crear Base de Datos PostgreSQL

### En Render Dashboard:
1. **New** → **PostgreSQL**
2. **Name**: `plataforma-educativa-db`
3. **Database**: `plataforma_educativa`
4. **User**: `admin` (o el que prefieras)
5. **Region**: Elegir la más cercana
6. **Plan**: Free tier
7. **Create Database**

### Guardar Credenciales:
Render te proporcionará:
- **Internal Database URL**
- **External Database URL** 
- **Host, Port, Database, Username, Password**

## Paso 2: Crear Web Service

### En Render Dashboard:
1. **New** → **Web Service**
2. **Connect Repository**: Seleccionar tu repositorio
3. **Name**: `plataforma-educativa`
4. **Region**: Misma que la base de datos
5. **Branch**: `main` (o tu rama principal)
6. **Root Directory**: `.` (vacío)
7. **Runtime**: `Docker` o `Native Environment`

### Build & Deploy Settings:
```bash
# Build Command:
./render-build.sh

# Start Command:
php artisan serve --host=0.0.0.0 --port=$PORT
```

## Paso 3: Variables de Entorno

### En Web Service → Environment:
```env
APP_NAME=Plataforma Educativa
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.onrender.com

# Base de datos (usar las credenciales de PostgreSQL creado)
DB_CONNECTION=pgsql
DB_HOST=tu-db-host.render.com
DB_PORT=5432
DB_DATABASE=plataforma_educativa
DB_USERNAME=admin
DB_PASSWORD=tu-password-seguro

# Cache y sesiones
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Laravel key (generar nueva)
APP_KEY=base64:TU_CLAVE_GENERADA_AQUI
```

### Generar APP_KEY:
```bash
# Local (copia el resultado)
php artisan key:generate --show
```

## Paso 4: Configurar Auto-Deploy

### En Web Service → Settings → Build & Deploy:
1. ✅ **Auto-Deploy**: Yes
2. **Branch**: main
3. **Build Command**: `./render-build.sh`
4. **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

## Paso 5: Deploy

1. **Deploy Latest Commit** en Render Dashboard
2. Monitor logs en tiempo real
3. ¡La app se desplegará automáticamente!

## 🔄 Reinicio Automático de BD

El script `render-build.sh` incluye:
```bash
# Reinicia completamente la BD en cada deploy
php artisan migrate:fresh --force --seed
```

**⚠️ IMPORTANTE**: Esto eliminará TODOS los datos existentes en cada deploy.

## URLs Finales

- **App**: `https://tu-app.onrender.com`
- **Database**: Accesible desde la app automáticamente

## 🛠️ Scripts Incluidos

- `render-build.sh`: Build y setup inicial
- `render-postdeploy.sh`: Tareas post-deploy
- `.env.render`: Plantilla de variables de entorno

## ✅ Verificación Post-Deploy

1. App carga correctamente
2. Login funciona
3. Base de datos tiene datos de prueba
4. Dark mode funciona
5. Todos los módulos cargan

## 🔧 Troubleshooting

### Error de Permisos:
```bash
chmod +x render-build.sh
chmod +x render-postdeploy.sh
```

### Error de Base de Datos:
- Verificar credenciales en variables de entorno
- Verificar que PostgreSQL esté running
- Revisar logs de build

### Error de Assets:
- Verificar que `npm run build` completó
- Verificar Node.js version en Render

## 📞 Soporte

Si hay problemas:
1. Revisar logs en Render Dashboard
2. Verificar variables de entorno
3. Comprobar conexión a BD desde logs
