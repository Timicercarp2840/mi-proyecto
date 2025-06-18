# SABLE - Sistema de Aprendizaje de Base Linux Educativa

Sistema completo de aprendizaje en línea desarrollado con Laravel 10 + Vue 3.

## 🚀 Instalación y Configuración

### Prerrequisitos
- PHP 8.1 o superior
- Composer
- Node.js 18 o superior
- NPM
- SQLite (incluido por defecto)

### Pasos de Instalación

1. **Instalar dependencias de PHP**
```bash
composer install
```

2. **Instalar dependencias de Node.js**
```bash
npm install
```

3. **Configurar la base de datos**
```bash
php artisan migrate:fresh --seed
php artisan db:seed --class=AdminUserSeeder
```

4. **Compilar assets**
```bash
npm run build
```

5. **Iniciar el servidor**
```bash
php artisan serve
```

## 👤 Usuarios de Prueba

### Administrador
- **Email:** admin@sable.com
- **Contraseña:** admin123

### Estudiante
- **Email:** estudiante@sable.com  
- **Contraseña:** estudiante123

## 📚 Funcionalidades

### Para Estudiantes
- ✅ Registro y login
- ✅ Dashboard con progreso personal
- ✅ Visualización de módulos por nivel
- ✅ Realización de evaluaciones interactivas
- ✅ Seguimiento del progreso
- ✅ Interfaz responsive

### Para Administradores
- ✅ Dashboard con métricas del sistema
- ✅ CRUD completo de módulos
- ✅ CRUD completo de evaluaciones
- ✅ Gestión de usuarios y roles
- ✅ Visualización de progreso de estudiantes

## 🏗️ Arquitectura

### Backend (Laravel 10)
- **Modelos:** User, Modulo, Evaluacion, Progreso
- **Controladores:** AuthController, DashboardController, ModuloController, EvaluacionController, ProgresoController, AdminController
- **Middleware:** AdminMiddleware para proteger rutas de administración
- **Autenticación:** Laravel Breeze con Inertia.js

### Frontend (Vue 3 + Inertia.js)
- **Layout:** AuthenticatedLayout con navegación dinámica según rol
- **Páginas:** Dashboard, módulos, evaluaciones, administración
- **Estilos:** TailwindCSS para diseño responsive
- **Estado:** Manejo reactivo con Vue 3 Composition API

### Base de Datos
- **SQLite** para desarrollo
- **Migraciones** con estructura completa
- **Seeders** con datos de prueba

## 📊 Modelo de Datos

### Usuario
- id, nombre, email, contraseña, rol (estudiante|administrador)

### Módulo  
- id_modulo, nivel, titulo, descripcion, contenido

### Evaluación
- id_eval, id_modulo, contenido_eval (JSON con preguntas)

### Progreso
- id_usuario, id_modulo, estado (en_proceso|completado), puntuacion

## 🛣️ Rutas Principales

### Públicas
- `/` - Página de bienvenida
- `/login` - Inicio de sesión
- `/register` - Registro

### Estudiantes (autenticados)
- `/dashboard` - Dashboard personal
- `/modulos` - Lista de módulos
- `/modulos/{id}` - Ver módulo específico
- `/evaluaciones/{id}/tomar` - Realizar evaluación
- `/mi-progreso` - Progreso personal

### Administradores
- `/admin/dashboard` - Dashboard administrativo
- `/admin/modulos` - Gestión de módulos
- `/admin/evaluaciones` - Gestión de evaluaciones
- `/admin/usuarios` - Gestión de usuarios

## 🎨 Diseño

- **Framework CSS:** TailwindCSS
- **Componentes:** Diseño modular y reutilizable
- **Responsive:** Compatible con móviles y tablets
- **UX:** Interfaz intuitiva y moderna
- **Accesibilidad:** Implementa buenas prácticas

## 🔧 Desarrollo

### Comandos útiles

```bash
# Desarrollo con hot-reload
npm run dev

# Compilar para producción
npm run build

# Ejecutar tests
php artisan test

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Crear nuevo módulo con evaluación
php artisan db:seed --class=ModuloSeeder
php artisan db:seed --class=EvaluacionSeeder
```

### Estructura de archivos

```
app/
├── Http/Controllers/     # Controladores
├── Models/              # Modelos Eloquent
├── Http/Middleware/     # Middleware personalizado
└── Providers/          # Service Providers

resources/
├── js/
│   ├── Components/     # Componentes Vue reutilizables
│   ├── Layouts/       # Layouts principales
│   └── Pages/         # Páginas de la aplicación
└── css/               # Estilos globales

database/
├── migrations/        # Migraciones de base de datos
└── seeders/          # Datos de prueba
```

## 🚀 Despliegue

1. **Configurar variables de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

2. **Configurar base de datos en producción**
```bash
# En .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sable
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

3. **Migrar y poblar base de datos**
```bash
php artisan migrate --force
php artisan db:seed --force
```

4. **Compilar assets para producción**
```bash
npm run build
```

## 📝 Características Técnicas

- **Laravel 10** con PHP 8.1+
- **Vue 3** con Composition API
- **Inertia.js** para SPA sin APIs
- **TailwindCSS** para estilos
- **SQLite/MySQL** como base de datos
- **Laravel Breeze** para autenticación
- **Vite** para bundling de assets
- **Middleware** personalizado para roles
- **Validaciones** completas en backend y frontend
- **Responsive design** mobile-first

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu funcionalidad (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crea un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para detalles.

---

**SABLE** - Sistema de Aprendizaje de Base Linux Educativa
Desarrollado con ❤️ usando Laravel + Vue.js
