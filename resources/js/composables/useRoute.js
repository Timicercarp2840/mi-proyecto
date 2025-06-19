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
        }
        
        return url || '/';
    };

    return {
        route
    };
}
