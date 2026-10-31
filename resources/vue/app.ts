import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import 'element-plus/es/components/notification/style/css'
import 'element-plus/es/components/message-box/style/css'
import DashboardLayout from '@/layouts/dashboard.vue'
import AppLayout from '@/layouts/app.vue'
import { createPinia } from 'pinia'
import { ZiggyVue } from 'ziggy-js'
import { App } from 'vue'

// element configuration
import './config/element'

// stylesheets
import 'element-plus/theme-chalk/dark/css-vars.css'
import '../css/app.css'
import 'animate.css'

// pinia
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

const app = createInertiaApp({
    title: (title) => title,
    withApp(app: App) {
        // components
        app.component('DashboardLayout', DashboardLayout)
        app.component('AppLayout', AppLayout)
        app.component('Link', Link)
        app.component('Head', Head)
        // plugins
        app.use(ZiggyVue)
        app.use(pinia)
    },
    progress: false,
    pages: {
        path: './pages',
    },
})

app.then(() => console.log('The application has successfully loaded.'))

if ('serviceWorker' in navigator && import.meta.env.PROD) {
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('/sw.js')
            .then((registration) => {
                console.log('Service worker registered:', registration.scope)
            })
            .catch((error) => {
                console.error('Service worker registration failed:', error)
            })
    })
}
