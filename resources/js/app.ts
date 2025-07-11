import '../css/app.css';
import '../css/animated-background.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import Index from './pages/tasks/Index.vue';
import '@fortawesome/fontawesome-free/css/all.min.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });

        vueApp.component('Index', Index);

        vueApp.use(plugin);
        vueApp.use(ZiggyVue);

        vueApp.mount(el);
    },
    progress: {
        color: '#4B5563'
    }
});

initializeTheme();
