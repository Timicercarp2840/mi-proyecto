<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'SABLE') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        <link rel="alternate icon" href="/favicon.ico">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script>
            // Route helper fallback - Load immediately before any other scripts
            if (typeof window !== 'undefined' && !window.route) {
                window.route = function(name, params = {}) {
                    const routes = {
                        'login': '/login',
                        'register': '/register',
                        'dashboard': '/dashboard',
                        'password.request': '/forgot-password',
                        'password.reset': '/reset-password',
                        'verification.send': '/email/verification-notification',
                        'profile.update': '/profile',
                        'password.update': '/password',
                        'profile.destroy': '/profile',
                        'modulos.index': '/modulos',
                        'modulos.show': function(params) { return '/modulos/' + (params.modulo || params.id || ''); },
                        'admin.dashboard': '/admin/dashboard',
                        'admin.usuarios': '/admin/usuarios',
                        'admin.modulos': '/admin/modulos',
                        'admin.modulos.store': '/admin/modulos',
                        'admin.modulos.update': function(params) { return '/admin/modulos/' + (params.modulo || params.id || ''); },
                        'admin.evaluaciones': '/admin/evaluaciones',
                        'progreso.actualizar': function(params) { return '/progreso/actualizar/' + (params.modulo || params.id || ''); },
                        'progreso.mi-progreso': '/progreso/mi-progreso',
                        'evaluaciones.tomar': function(params) { return '/evaluaciones/tomar/' + (params.evaluacion || params.id || ''); },
                        'gamificacion.leaderboard': '/gamificacion/leaderboard',
                        'gamificacion.perfil': '/gamificacion/perfil',
                    };

                    let url = routes[name];
                    
                    if (typeof url === 'function') {
                        return url(params);
                    }
                    
                    if (url && params && Object.keys(params).length > 0) {
                        Object.keys(params).forEach(function(key) {
                            url = url.replace('{' + key + '}', params[key]);
                        });
                    }
                    
                    return url || '/';
                };
                console.log('Inline route helper loaded');
            }
        </script>
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
