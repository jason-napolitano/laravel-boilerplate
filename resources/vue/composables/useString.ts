export function useString() {
    /** --------------------------------------------
     * Truncate a string and add an ellipsis to the
     * end of it
     */
    function truncate(input: string, n: number = 55, end: string | null = '...'): string {
        return input.length > 5 ? input.substring(0, n) + end : (input ?? '')
    }

    /** --------------------------------------------
     * Removes hyphens (EG: '-' )  from a string
     */
    function removeHyphens(phrase: string): string {
        return phrase.replace(/-/g, ' ')
    }

    /** --------------------------------------------
     * Removes underscores (EG: '_' )  from a string
     */
    function removeUnderscores(phrase: string): string {
        return phrase.replace(/_/g, ' ')
    }

    /** --------------------------------------------
     * Removes commas (EG: ',' )  from a string
     */
    function removeCommas(phrase: string): string {
        return phrase.replace(/,/g, ' ')
    }

    /** --------------------------------------------
     * Converts the first letter of each word in
     * a multi-word string to uppercase
     */
    function toTitleCase(phrase: string): string {
        return phrase
            .toLowerCase()
            .split(' ')
            .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
            .join(' ')
    }

    /** --------------------------------------------
     * Capitalize the first letter in a string
     */
    function ucFirst(string: string): string {
        return string.charAt(0).toUpperCase() + string.slice(1)
    }

    /** --------------------------------------------
     * Creates a slug formatted string
     */
    function slug(str: string): string {
        return str
            .trim()
            .toLowerCase()
            .replace(/[\W_]+/g, '-')
            .replace(/^-+|-+$/g, '')
    }

    /** --------------------------------------------
     * Removes a trailing comma from a string
     */
    function removeTrailingComma(value: string): string {
        return value.replace(/, \s*$/, '').replace(/,\s*$/, '')
    }

    // -------------------------------------------
    // singular and plural
    const irregular: { [key: string]: string } = {
        move: 'moves',
        foot: 'feet',
        goose: 'geese',
        sex: 'sexes',
        child: 'children',
        man: 'men',
        tooth: 'teeth',
        person: 'people',
    }
    const uncountable: string[] = [
        'sheep',
        'fish',
        'deer',
        'moose',
        'series',
        'species',
        'money',
        'rice',
        'information',
        'equipment',
        'bison',
        'cod',
        'offspring',
        'pike',
        'salmon',
        'shrimp',
        'swine',
        'trout',
        'aircraft',
        'hovercraft',
        'spacecraft',
        'sugar',
        'tuna',
        'you',
        'wood',
    ]

    /** --------------------------------------------
     * Returns the plural of an English word.
     */
    function plural(word: string, amount?: number): string {
        if (amount !== undefined && amount === 1) {
            return word
        }
        const plural: { [key: string]: string } = {
            '(quiz)$': '$1zes',
            '^(ox)$': '$1en',
            '([m|l])ouse$': '$1ice',
            '(matr|vert|ind)ix|ex$': '$1ices',
            '(x|ch|ss|sh)$': '$1es',
            '([^aeiouy]|qu)y$': '$1ies',
            '(hive)$': '$1s',
            '(?:([^f])fe|([lr])f)$': '$1$2ves',
            '(shea|lea|loa|thie)f$': '$1ves',
            sis$: 'ses',
            '([ti])um$': '$1a',
            '(tomat|potat|ech|her|vet)o$': '$1oes',
            '(bu)s$': '$1ses',
            '(alias)$': '$1es',
            '(octop)us$': '$1i',
            '(ax|test)is$': '$1es',
            '(us)$': '$1es',
            '([^s]+)$': '$1s',
        }
        // save some time in the case that singular and plural are the same
        if (uncountable.indexOf(word.toLowerCase()) >= 0) {
            return word
        }
        // check for irregular forms
        for (const w in irregular) {
            const pattern = new RegExp(`${w}$`, 'i')
            const replace = irregular[w]
            if (pattern.test(word)) {
                return word.replace(pattern, replace)
            }
        }
        // check for matches using regular expressions
        for (const reg in plural) {
            const pattern = new RegExp(reg, 'i')
            if (pattern.test(word)) {
                return word.replace(pattern, plural[reg])
            }
        }
        return word
    }

    /** --------------------------------------------
     * Returns a possessive pluralization or
     * standard pluralization of a word
     */
    function pluralPossessive(word: string): string {
        const value = word.trim()

        // Already possessive
        if (value.endsWith("'") || value.endsWith("'s")) {
            return value
        }

        // Common irregular plural nouns
        const irregularPlurals = new Set(['children', 'men', 'women', 'people', 'mice', 'geese', 'teeth', 'feet'])

        // Irregular plural → add 's
        if (irregularPlurals.has(value.toLowerCase())) {
            return `${value}'s`
        }

        // Regular plural → add apostrophe
        if (value.endsWith('s')) {
            return `${value}'`
        }

        // Singular → add 's
        return `${value}'s`
    }

    /** --------------------------------------------
     * Returns the singular of an English word
     */
    function singular(word: string, amount?: number): string {
        if (amount !== undefined && amount !== 1) {
            return word
        }
        const singular: { [key: string]: string } = {
            '(quiz)zes$': '$1',
            '(matr)ices$': '$1ix',
            '(vert|ind)ices$': '$1ex',
            '^(ox)en$': '$1',
            '(alias)es$': '$1',
            '(octop|vir)i$': '$1us',
            '(cris|ax|test)es$': '$1is',
            '(shoe)s$': '$1',
            '(o)es$': '$1',
            '(bus)es$': '$1',
            '([m|l])ice$': '$1ouse',
            '(x|ch|ss|sh)es$': '$1',
            '(m)ovies$': '$1ovie',
            '(s)eries$': '$1eries',
            '([^aeiouy]|qu)ies$': '$1y',
            '([lr])ves$': '$1f',
            '(tive)s$': '$1',
            '(hive)s$': '$1',
            '(li|wi|kni)ves$': '$1fe',
            '(shea|loa|lea|thie)ves$': '$1f',
            '(^analy)ses$': '$1sis',
            '((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$': '$1$2sis',
            '([ti])a$': '$1um',
            '(n)ews$': '$1ews',
            '(h|bl)ouses$': '$1ouse',
            '(corpse)s$': '$1',
            '(us)es$': '$1',
            s$: '',
        }
        // save some time in the case that singular and plural are the same
        if (uncountable.indexOf(word.toLowerCase()) >= 0) {
            return word
        }
        // check for irregular forms
        for (const w in irregular) {
            const pattern = new RegExp(`${irregular[w]}$`, 'i')
            if (pattern.test(word)) {
                return word.replace(pattern, w)
            }
        }
        // check for matches using regular expressions
        for (const reg in singular) {
            const pattern = new RegExp(reg, 'i')
            if (pattern.test(word)) {
                return word.replace(pattern, singular[reg])
            }
        }
        return word
    }

    /** --------------------------------------------
     * Converts a phone number into a human-readable string
     */
    function phoneNumber(phone: string): string | null {
        const cleaned = ('' + phone).replace(/\D/g, '')
        const match = cleaned.match(/^(1|)?(\d{3})(\d{3})(\d{4})$/)
        if (match) {
            const intlCode = match[1] ? '+1 ' : ''
            return [intlCode, '(', match[2], ') ', match[3], '-', match[4]].join('')
        }
        return null
    }

    /** --------------------------------------------
     * Formats a URL
     */
    function url(url: string) {
        // Trim spaces around the URL
        url = url.trim()

        // Remove the protocol (http:// or https://)
        if (url.startsWith('http://')) {
            url = url.substring(7) // Remove 'http://'
        } else if (url.startsWith('https://')) {
            url = url.substring(8) // Remove 'https://'
        }

        return url
    }

    /** --------------------------------------------
     * Replaces characters in a string
     */
    const replace = (string: string, replace: string, using: string) => string.replaceAll(replace, using)

    return {
        removeTrailingComma,
        removeUnderscores,
        pluralPossessive,
        removeHyphens,
        removeCommas,
        toTitleCase,
        phoneNumber,
        truncate,
        singular,
        replace,
        ucFirst,
        plural,
        slug,
        url,
    }
}
