import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import Index from './pages/tasks/Index.vue';

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

        // 👇 Register your global component
        vueApp.component('Index', Index);

        // 👇 Attach plugins
        vueApp.use(plugin);
        vueApp.use(ZiggyVue);

        // 👇 Mount the app
        vueApp.mount(el);
    },
    progress: {
        color: '#4B5563'
    }
});

// This will set light / dark mode on page load...
initializeTheme();
