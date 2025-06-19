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
        }
        
        // Fallback con rutas estáticas
        const routes = {
            'login': '/login',
            'register': '/register',
            'dashboard': '/dashboard',
            'modulos.index': '/modulos',
            'modulos.show': (params) => `/modulos/${params.modulo || params.id || ''}`,
            'admin.dashboard': '/admin/dashboard',
            'admin.usuarios': '/admin/usuarios',
            'admin.modulos': '/admin/modulos',
            'admin.evaluaciones': '/admin/evaluaciones',
            'profile.edit': '/profile',
            'progreso.mi-progreso': '/progreso/mi-progreso',
            'gamificacion.leaderboard': '/gamificacion/leaderboard',
            'gamificacion.perfil': '/gamificacion/perfil',
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
