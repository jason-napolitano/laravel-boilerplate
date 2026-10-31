export function useObject() {
    /** ---------------------------------------------
     * Checks if an object is empty
     */
    const empty = (object: object): boolean => Object.keys(object).length > 0

    return { empty }
}
