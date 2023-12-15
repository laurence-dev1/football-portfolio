import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

import Layout from '@/Shared/Layout.vue';
import { createPinia } from "pinia";
import axios from "axios";

// will be globally available (via provide/inject) to be used when aborting ongoing requests
let abortController = new AbortController();
axios.defaults.signal = abortController.signal;

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })

        let page = pages[`./Pages/${name}.vue`];
        if (page.default.layout === undefined) {
            page.default.layout = Layout;
        }

        return page;
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .provide('axiosAbortSignal', abortController)
            .use(plugin)
            .use(createPinia())
            .mount(el)
    },

    title: title => `${title} | Football Portfolio`,
});
