export function useApp() {
    // ---------------------------------------------
    // composables
    const slots = useSlots()

    /** --------------------------------------------
     * Determines if a slot is empty
     */
    const slotEmpty = (slot: string): boolean => !slots[slot] || slots[slot]().length === 0

    /** --------------------------------------------
     * Returns the value of an environment variable
     */
    const env = (key: string): any => import.meta.env[`VITE_APP_${key}`]

    return { slotEmpty, env }
}
