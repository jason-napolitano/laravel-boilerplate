import { useRoute } from './useRoute'
import DOMPurify from 'dompurify'

export function useMarkup() {
    // ---------------------------------------------
    // current route
    const { current } = useRoute()

    /** --------------------------------------------
     * Returns a class name if the route passed through
     * matches th current route
     */
    const activeClass = (route: string, activeClass: string = 'is-active'): string => (current(route) ? activeClass : '')

    /** --------------------------------------------
     * Sanitize a markup string
     */
    const sanitize = (string: string): string => DOMPurify.sanitize(string)

    /** --------------------------------------------
     * Returns random hex codes
     */
    function randomHexCodes(amount = 1, baseColors = []) {
        const colorRanges = {
            red: [
                [128, 255],
                [0, 127],
                [0, 127],
            ],
            green: [
                [0, 127],
                [128, 255],
                [0, 127],
            ],
            blue: [
                [0, 127],
                [0, 127],
                [128, 255],
            ],
            yellow: [
                [128, 255],
                [128, 255],
                [0, 127],
            ],
            cyan: [
                [0, 127],
                [128, 255],
                [128, 255],
            ],
            magenta: [
                [128, 255],
                [0, 127],
                [128, 255],
            ],
            orange: [
                [200, 255],
                [80, 165],
                [0, 80],
            ],
            purple: [
                [80, 200],
                [0, 100],
                [128, 255],
            ],
            pink: [
                [220, 255],
                [100, 200],
                [140, 255],
            ],
            black: [
                [0, 60],
                [0, 60],
                [0, 60],
            ],
            white: [
                [200, 255],
                [200, 255],
                [200, 255],
            ],
            gray: [
                [50, 220],
                [50, 220],
                [50, 220],
            ],
        }

        const randomInt = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min

        const toHex = (value) => value.toString(16).padStart(2, '0')

        const colors = baseColors.map((color) => color.toLowerCase()).filter((color) => colorRanges[color])

        return Array.from({ length: amount }, () => {
            if (colors.length === 0) {
                return `#${randomInt(0, 0xffffff).toString(16).padStart(6, '0')}`
            }

            const color = colors[randomInt(0, colors.length - 1)]
            const ranges = colorRanges[color]

            const [r, g, b] = ranges.map(([min, max]) => randomInt(min, max))

            return `#${toHex(r)}${toHex(g)}${toHex(b)}`
        })
    }

    return { activeClass, sanitize, randomHexCodes }
}
