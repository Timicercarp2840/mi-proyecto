// Vue plugin para proporcionar route() globalmente
export default {
    install(app) {
        // Asegurar que route esté disponible globalmente
        if (!window.route) {
            console.warn('Route helper not found, creating fallback...');
            window.route = function(name, params = {}) {
                const routes = {
                    'login': '/login',
                    'register': '/register',
                    'dashboard': '/dashboard',
                };
                return routes[name] || '/';
            };
        }
        
        // Proporcionar route() como propiedad global de Vue
        app.config.globalProperties.$route = window.route;
        app.provide('route', window.route);
        
        console.log('Vue route plugin installed');
    }
};
