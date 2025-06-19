// Global route helper function - Load immediately
(function() {
    'use strict';
    
    console.log('Loading route helper...');
    
    // Helper function for routes when Ziggy is not available
    function route(name, params = {}) {        // Basic route mapping for common routes
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
            'modulos.index': '/modulos',
            'modulos.show': (params) => `/modulos/${params.modulo || params.id || params.id_modulo || ''}`,            'admin.dashboard': '/admin/dashboard',
            'admin.usuarios': '/admin/usuarios',
            'admin.modulos': '/admin/modulos',
            'admin.evaluaciones': '/admin/evaluaciones',
            'admin.desafios': '/admin/desafios',
            'admin.estadisticas': '/admin/estadisticas',
            'profile.edit': '/profile',
            'progreso.mi-progreso': '/progreso/mi-progreso',
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
            // Simple parameter replacement
            Object.keys(params).forEach(key => {
                url = url.replace(`{${key}}`, params[key]);
            });
        }
        
        return url || '/';
    }

    // Make it globally available immediately
    if (typeof window !== 'undefined') {
        window.route = route;
        console.log('Route helper loaded successfully');
    }
    
    // Also make it available as a global for SSR
    if (typeof global !== 'undefined') {
        global.route = route;
    }
    
    // For module systems
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = route;
    }
})();
