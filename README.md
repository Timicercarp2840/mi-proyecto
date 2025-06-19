# 🎓 SABLE - Sistema de Aprendizaje de Base Linux Educativa

Plataforma educativa interactiva para el aprendizaje de comandos Linux y desarrollo de habilidades tecnológicas. Desarrollada con **Laravel 10**, **Vue 3**, **Inertia.js** y **Tailwind CSS**.

## ✨ Características

### 🎯 **Funcionalidades Principales**
- **Terminal Interactivo**: Simulador de terminal Linux en el navegador
- **Sistema de Módulos**: Contenido educativo estructurado por niveles
- **Desafíos Gamificados**: Retos prácticos con sistema de recompensas
- **Panel de Administración**: CRUD completo para gestión de contenido
- **Progreso del Usuario**: Seguimiento detallado de avances
- **Sistema de Insignias**: Gamificación con logros y recompensas
- **Dark Mode**: Interfaz adaptable con modo claro/oscuro

### 🎮 **Características Avanzadas**
- **Evaluaciones Automáticas**: Sistema de validación de comandos
- **Asignación Automática**: Contenido se asigna automáticamente a nuevos usuarios
- **Perfil Unificado**: Vista completa de progreso, estadísticas y ranking
- **Navegación Intuitiva**: Interfaz moderna y responsive

## 🚀 Instalación Local

### **Prerrequisitos**
- PHP 8.2+
- Composer
- Node.js 18+
- NPM

### **Configuración Rápida**
```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/mi-proyecto.git
cd mi-proyecto

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar base de datos y seeders
php artisan migrate:fresh --seed

# 5. Asignar contenido a usuarios
php artisan usuarios:asignar-contenido --solo-nuevos

# 6. Compilar assets y ejecutar
npm run build
php artisan serve
```

## 🔑 Credenciales de Acceso

### 👨‍💼 **Administrador**
- **Email**: `admin@sable.com`
- **Contraseña**: `admin123`
- **Acceso**: Panel de administración completo

### 👨‍🎓 **Estudiante**
- **Email**: `estudiante@sable.com`
- **Contraseña**: `estudiante123`
- **Acceso**: Módulos, desafíos y progreso

## 🐳 Deploy en Render.com

### **Deploy Automático**
La aplicación está configurada para deploy automático en Render con Docker:

1. **Fork/Clone** este repositorio
2. **Conecta** tu repo a Render.com
3. **Configura** las variables de entorno:
   ```
   APP_URL=https://tu-app.onrender.com
   ASSET_URL=https://tu-app.onrender.com
   APP_ENV=production
   FORCE_HTTPS=true
   ```
4. **Deploy automático** se ejecutará usando `render.yaml`

### **Variables de Entorno Requeridas**
```bash
APP_KEY=base64:TU_KEY_AQUI  # php artisan key:generate --show
DB_CONNECTION=pgsql         # PostgreSQL automático en Render
DB_HOST=                    # Render lo llena automáticamente
DB_DATABASE=                # Render lo llena automáticamente
DB_USERNAME=                # Render lo llena automáticamente
DB_PASSWORD=                # Render lo llena automáticamente
```

## 📁 Estructura del Proyecto

### **Backend (Laravel)**
```
app/
├── Http/Controllers/          # Controladores principales
│   ├── AdminDesafioController.php    # CRUD de desafíos
│   ├── PerfilUnificadoController.php # Perfil completo
│   └── DesafioLibreController.php    # Terminal libre
├── Models/                    # Modelos de datos
├── Console/Commands/          # Comandos Artisan
└── Listeners/                 # Event listeners
```

### **Frontend (Vue 3 + Inertia)**
```
resources/js/
├── Pages/                     # Páginas principales
│   ├── Admin/                # Dashboard administrativo
│   ├── Perfil/               # Perfil unificado
│   ├── DesafioLibre/         # Terminal interactivo
│   └── Desafios/             # Módulos de aprendizaje
├── Components/               # Componentes reutilizables
└── Layouts/                  # Layouts principales
```

## 🎮 Módulos Disponibles

1. **📱 Terminal Básico**: Comandos fundamentales (pwd, ls, cd)
2. **📂 Gestión de Archivos**: Creación, copia, movimiento
3. **🔍 Búsqueda y Filtrado**: find, grep, ubicación de archivos
4. **⚙️ Sistema y Procesos**: Gestión del sistema
5. **🔒 Permisos**: Configuración de permisos y seguridad

## 🛠️ Tecnologías

- **Backend**: Laravel 10, PHP 8.2
- **Frontend**: Vue 3, Inertia.js, Tailwind CSS
- **Base de datos**: PostgreSQL (producción), SQLite (desarrollo)
- **Deploy**: Docker, Render.com
- **Herramientas**: Vite, Composer, NPM

## 🚀 Comandos Útiles

```bash
# Desarrollo
npm run dev              # Servidor de desarrollo
php artisan serve        # Servidor Laravel

# Producción
npm run build            # Build de assets
php artisan optimize     # Optimizar aplicación

# Base de datos
php artisan migrate:fresh --seed                    # Reiniciar DB
php artisan usuarios:asignar-contenido --solo-nuevos # Asignar contenido

# Cache
php artisan cache:clear  # Limpiar cache
php artisan config:cache # Cache de configuración
```

## 📊 Estado del Proyecto

- ✅ **Funcional**: Aplicación completamente operativa
- ✅ **Deploy Ready**: Configurado para producción en Render
- ✅ **Docker Ready**: Containerización completa
- ✅ **HTTPS Configurado**: SSL/TLS en producción
- ✅ **Responsive**: Adaptable a móviles y desktop

## 🎯 Demo

**URL de Demo**: [https://sable-app.onrender.com](https://sable-app.onrender.com)

Usa las credenciales proporcionadas arriba para probar todas las funcionalidades.

## 📝 Licencia

Este proyecto es de código abierto y está disponible bajo la [Licencia MIT](LICENSE).

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:
1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

**Desarrollado con ❤️ para la educación en tecnología**
