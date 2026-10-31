import { router, usePage } from '@inertiajs/vue3'

export function useRoute() {
    // ---------------------------------------------
    // page data
    const page = usePage()

    /** --------------------------------------------
     * Returns a boolean if the current route matches
     * the route passed through
     */
    const current = (to: string): boolean => route().current(to)

    /** --------------------------------------------
     * Apply / append / remove filter(s) to / from the
     * current URL
     */
    function toggleFilters(key: string, value: string | number, href: string = null): void {
        const url = new URL(window.location.href)
        const params = url.searchParams

        const filterKey = `filter[${key}]`

        if (params.has(filterKey)) {
            // Remove the filter if it exists
            params.delete(filterKey)
        } else {
            // Add the filter if it does not exist
            params.set(filterKey, value as string)
        }

        // Build the new query string
        const query = params.toString()

        router.get(
            href ? `${route(href)}?${query}` : `${url.pathname}?${query}`,
            {},
            {
                preserveState: true,
                replace: true,
            },
        )
    }

    /** --------------------------------------------
     * Reset the current filter(s)
     */
    function resetFilters(): void {
        router.get(
            page.url.split('?')[0],
            {},
            {
                replace: true,
                preserveState: true,
            },
        )
    }

    return { resetFilters, toggleFilters, current }
}
