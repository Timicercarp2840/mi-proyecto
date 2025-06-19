import { ref, computed } from 'vue'

/**
 * Composable para manejar rutas de manera consistente
 */
export function useRoute() {
    // Función route que siempre funciona
    const route = (name, params = {}) => {
        // Intentar usar window.route si está disponible
        if (typeof window !== 'undefined' && window.route) {
            return window.route(name, params);
        }        // Fallback con rutas estáticas
        const routes = {
            'home': '/',
            'login': '/login',
            'register': '/register',
            'logout': '/logout',
            'dashboard': '/dashboard',            'password.request': '/forgot-password',
            'password.reset': '/reset-password',
            'password.email': '/forgot-password',
            'password.store': '/reset-password',
            'password.confirm': '/confirm-password',
            'verification.send': '/email/verification-notification',
            'profile.update': '/profile',
            'password.update': '/password',
            'profile.destroy': '/profile',
            'modulos.index': '/modulos',
            'modulos.show': (params) => `/modulos/${params.modulo || params.id || params.id_modulo || ''}`,            'admin.dashboard': '/admin/dashboard',
            'admin.usuarios': '/admin/usuarios',
            'admin.modulos': '/admin/modulos',
            'admin.modulos.store': '/admin/modulos',
            'admin.modulos.update': (params) => `/admin/modulos/${params.modulo || params.id || ''}`,
            'admin.evaluaciones': '/admin/evaluaciones',
            'admin.evaluaciones.store': (params) => `/admin/modulos/${params.id_modulo || params.modulo || ''}/evaluaciones`,
            'admin.desafios': '/admin/desafios',
            'admin.estadisticas': '/admin/estadisticas',
            'progreso.actualizar': (params) => `/progreso/actualizar/${params.modulo || params.id || ''}`,
            'progreso.mi-progreso': '/progreso/mi-progreso',
            'evaluaciones.tomar': (params) => `/evaluaciones/tomar/${params.evaluacion || params.id || ''}`,
            'gamificacion.leaderboard': '/gamificacion/leaderboard',
            'gamificacion.perfil': '/gamificacion/perfil',
            'desafios.terminal': '/desafios/terminal',
            'desafios.filesystem': '/desafios/filesystem',
            'desafios.permisos': '/desafios/permisos',
            'desafios.muro-comandos': '/muro-comandos',
            'desafios.libre': '/desafios/libre',
        };

        let url = routes[name];
        
        if (typeof url === 'function') {
            return url(params);
        }
        
        if (url && params && Object.keys(params).length > 0) {
            Object.keys(params).forEach(key => {
                url = url.replace(`{${key}}`, params[key]);
            });
        }        return url || '/';
    };

    // Agregar método current para verificar si la ruta actual coincide
    route.current = (name) => {
        if (typeof window !== 'undefined' && window.route && window.route.current) {
            return window.route.current(name);
        }
        
        // Fallback básico usando la URL actual
        if (typeof window !== 'undefined' && window.location) {
            const currentPath = window.location.pathname;
            
            // Verificaciones básicas para patrones comunes
            if (name === 'dashboard' && currentPath === '/dashboard') return true;
            if (name.includes('modulos') && currentPath.includes('/modulos')) return true;
            if (name.includes('admin.modulos') && currentPath.includes('/admin/modulos')) return true;
            if (name.includes('admin.usuarios') && currentPath.includes('/admin/usuarios')) return true;
            if (name.includes('admin.desafios') && currentPath.includes('/admin/desafios')) return true;
            if (name.includes('admin.estadisticas') && currentPath.includes('/admin/estadisticas')) return true;
            if (name.includes('desafios') && currentPath.includes('/desafios')) return true;
            if (name.includes('gamificacion') && currentPath.includes('/gamificacion')) return true;
        }
        
        return false;
    };

    // La función route ahora tiene el método current anexado
    return {
        route
    };
}
