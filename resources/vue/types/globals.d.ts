import { DatabaseRecord, SharedData } from '@/types/index'

declare global {
    function route(name: string, params?: object | DatabaseRecord | string | number, absolute?: boolean): string
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $page: import('@inertiajs/core').Page<SharedData>
        route: typeof route
    }
}
