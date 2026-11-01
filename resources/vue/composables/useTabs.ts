import { usePage, router } from '@inertiajs/vue3'

export function useTabs(defaultTab: string = null, param: string = 'tab') {
    const byQueryParam = computed({
        get() {
            const params = new URLSearchParams(window.location.search)

            return params.get(param) || defaultTab || '0'
        },

        set(value) {
            const params = new URLSearchParams(window.location.search)

            // Unnamed first tab (Element Plus internal name)
            if (!value || value === '0') {
                params.delete(param)
            } else {
                params.set(param, value)
            }

            const query = params.toString()

            router.replace({
                url: `${window.location.pathname}${query ? `?${query}` : ''}`
            })
        }
    })

    return { byQueryParam }
}
