export function useArray() {
    /** --------------------------------------------
     * Removes the duplicate entries from an array
     */
    function removeDuplicates(array: any[], key = 'id') {
        if (!Array.isArray(array)) return []

        const isArrayOfObjects = array.every((item) => typeof item === 'object' && item !== null && !Array.isArray(item))

        if (isArrayOfObjects) {
            // Remove duplicates based on the object key
            return [...new Map(array.map((item) => [item[key], item])).values()]
        } else {
            // Remove duplicates for primitive array
            return [...new Set(array)]
        }
    }

    /** --------------------------------------------
     * Extract values from an array of objects
     */
    function extractValues(arr: object[], key: string) {
        // Validate input
        if (!Array.isArray(arr)) {
            throw new TypeError('First argument must be an array.')
        }
        if (typeof key !== 'string') {
            throw new TypeError('Key must be a string.')
        }

        // Extract values safely
        return arr
            .filter((obj) => obj && typeof obj === 'object' && key in obj) // ensure object and key exists
            .map((obj) => obj[key])
    }

    return {
        removeDuplicates,
        extractValues,
    }
}
