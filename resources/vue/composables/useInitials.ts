export function useInitials() {
    /** ---------------------------------------------
     * Return initials from a two-word string
     */
    const getInitials = (str?: string): string => {
        if (!str) return ''

        const names = str.trim().split(' ')

        if (names.length === 0) return ''
        if (names.length === 1) return names[0].charAt(0).toUpperCase()

        return `${names[0].charAt(0)}${names[names.length - 1].charAt(0)}`.toUpperCase()
    }

    return { getInitials }
}
