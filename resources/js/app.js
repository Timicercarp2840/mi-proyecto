// Load route helper FIRST before anything else
import './route-helper';

import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import RoutePlugin from './plugins/route';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(RoutePlugin); // Añadir plugin de rutas
            
        // ZiggyVue will be available at runtime on the server
        // after composer install and ziggy:generate
        
        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
