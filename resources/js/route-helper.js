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
