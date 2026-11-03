import { router } from '@inertiajs/vue3'

export function useTabs(param: string = 'tab', defaultTab: string = null) {
    const params = new URLSearchParams(window.location.search)

    const byQueryParam = computed({
        get: () => params.get(param) || defaultTab || '0',
        set(value) {
            !value || value === '0' ? params.delete(param) : params.set(param, value)
            const query = params.toString()

            router.replace({
                url: `${window.location.pathname}${query ? `?${query}` : ''}`,
            })
        },
    })

    return { byQueryParam }
}
