# ✅ Checklist de Deploy en Render

## Pre-Deploy (Preparación)

### 🔧 Archivos de Configuración
- [ ] `render-build.sh` - Script de build principal
- [ ] `render-postdeploy.sh` - Script post-deploy
- [ ] `Procfile` - Comando de inicio
- [ ] `render.yaml` - Configuración de Render
- [ ] `.env.render` - Plantilla de variables de entorno
- [ ] `RENDER_DEPLOY_GUIDE.md` - Guía completa

### 📦 Dependencias y Assets
- [ ] `composer.json` actualizado
- [ ] `package.json` actualizado
- [ ] Assets compilados con `npm run build`
- [ ] Comando `usuarios:asignar-contenido` funcional

### 🗄️ Base de Datos
- [ ] Migraciones funcionando correctamente
- [ ] Seeders completando sin errores
- [ ] Comando `migrate:fresh --seed` probado localmente

## Deploy en Render

### 1. Base de Datos PostgreSQL
- [ ] Crear PostgreSQL Database en Render
- [ ] Anotar credenciales (host, database, username, password)
- [ ] Database está en estado "Available"

### 2. Web Service
- [ ] Crear Web Service en Render
- [ ] Conectar repositorio de GitHub/GitLab
- [ ] Configurar Build Command: `./render-build.sh`
- [ ] Configurar Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

### 3. Variables de Entorno
- [ ] `APP_NAME` = "Plataforma Educativa"
- [ ] `APP_ENV` = "production"
- [ ] `APP_DEBUG` = "false"
- [ ] `APP_URL` = URL de Render
- [ ] `APP_KEY` = Generar nueva clave
- [ ] `DB_CONNECTION` = "pgsql"
- [ ] `DB_HOST` = Host de PostgreSQL de Render
- [ ] `DB_PORT` = "5432"
- [ ] `DB_DATABASE` = Nombre de la base de datos
- [ ] `DB_USERNAME` = Usuario de PostgreSQL
- [ ] `DB_PASSWORD` = Password de PostgreSQL

### 4. Deploy
- [ ] Ejecutar "Deploy Latest Commit"
- [ ] Monitorear logs durante el build
- [ ] Verificar que el build completa sin errores

## Post-Deploy (Verificación)

### 🌐 Funcionamiento Básico
- [ ] App carga en la URL de Render
- [ ] Página de inicio se muestra correctamente
- [ ] CSS y JavaScript cargan correctamente

### 🔐 Autenticación
- [ ] Página de login accesible
- [ ] Registro de usuario funciona
- [ ] Login funciona correctamente
- [ ] Logout funciona

### 🎯 Funcionalidades Principales
- [ ] Dashboard carga para estudiantes
- [ ] Dashboard carga para administradores
- [ ] Dark mode funciona
- [ ] "Desafío Libre" muestra las 4 opciones
- [ ] "Mi Perfil Completo" muestra las 4 pestañas

### 📚 Contenido Educativo
- [ ] Módulos se muestran correctamente
- [ ] Progreso se calcula correctamente
- [ ] Desafíos interactivos funcionan
- [ ] Sistema de gamificación activo

### 🗄️ Base de Datos
- [ ] Usuarios de prueba existen (admin y estudiante)
- [ ] Módulos de ejemplo cargados
- [ ] Desafíos de ejemplo disponibles
- [ ] Relaciones entre tablas funcionando

## 🆘 Troubleshooting

### Si el Build Falla:
1. [ ] Revisar logs en Render Dashboard
2. [ ] Verificar permisos del script: `chmod +x render-build.sh`
3. [ ] Comprobar variables de entorno
4. [ ] Verificar conexión a PostgreSQL

### Si la App No Carga:
1. [ ] Verificar Start Command
2. [ ] Revisar logs de runtime
3. [ ] Comprobar `APP_KEY` configurado
4. [ ] Verificar `APP_URL` correcto

### Si la BD No Funciona:
1. [ ] Verificar credenciales de PostgreSQL
2. [ ] Comprobar que DB está "Available"
3. [ ] Revisar logs de migraciones
4. [ ] Verificar `DB_CONNECTION=pgsql`

## 🎉 Deploy Exitoso

Si todos los items están marcados ✅:
- La aplicación está funcionando en producción
- La base de datos se reinicia automáticamente en cada deploy
- Todas las funcionalidades están operativas
- Los usuarios pueden usar la plataforma educativa

## 📝 Notas Importantes

- ⚠️ `migrate:fresh` **ELIMINA** todos los datos en cada deploy
- 🔄 Auto-deploy está configurado desde rama main
- 💾 PostgreSQL debe estar en la misma región que el Web Service
- 🔐 Cambiar `APP_KEY` en producción por seguridad
