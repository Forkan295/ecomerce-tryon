import './bootstrap';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';

//using external package or plugin
import slugifyMixins from "@/Mixin/slugify";
import Toast from "vue-toastification";

//================ styles ============
import '../css/app.css';
import '../css/style.scss';
import "vue-toastification/dist/index.css";
//========================================



//========== Vuetify ==========
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css';
import {createVuetify} from 'vuetify'
import {aliases, mdi} from 'vuetify/iconsets/mdi'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        }
    },
})
//==================================================


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    // title: (title) => `${appName} - ${title}`,
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(Toast, {
                position: "bottom-right",
                timeout: 2000,
            })
            .use(plugin)
            .mixin(slugifyMixins)
            .use(vuetify)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
        showSpinner: true,
    },
});
