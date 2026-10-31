import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'
import Components from 'unplugin-vue-components/vite'
import AutoImport from 'unplugin-auto-import/vite'
import tailwindcss from '@tailwindcss/vite'
import laravel from 'laravel-vite-plugin'
import inertia from '@inertiajs/vite'
import vue from '@vitejs/plugin-vue'
import { resolve } from 'node:path'
import { defineConfig } from 'vite'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/vue/app.ts'],
            refresh: true,
        }),
        tailwindcss(),
        inertia(),
        vue(),
        Components({
            resolvers: [ElementPlusResolver()],
        }),
        AutoImport({
            imports: [
                'vue',
                'pinia',
                '@vueuse/core',
                {
                    '@inertiajs/vue3': ['useForm', 'usePage', 'useHttp'],
                },
                {
                    'element-plus': ['ElNotification', 'ElMessageBox'],
                },
            ],
            resolvers: [ElementPlusResolver()],
            dirs: ['./resources/vue/composables'],
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(import.meta.dirname, './resources/vue'),
            'ziggy-js': resolve(import.meta.dirname, 'vendor/tightenco/ziggy'),
        },
    },
    server: {
        // host: '127.0.0.1',
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
})
