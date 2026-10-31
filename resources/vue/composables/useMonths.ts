export function useMonths() {
    // ---------------------------------------------
    // months array
    const months = [
        { name: 'January', abbr: 'Jan' },
        { name: 'February', abbr: 'Feb' },
        { name: 'March', abbr: 'Mar' },
        { name: 'April', abbr: 'Apr' },
        { name: 'May', abbr: 'May' },
        { name: 'June', abbr: 'Jun' },
        { name: 'July', abbr: 'Jul' },
        { name: 'August', abbr: 'Aug' },
        { name: 'September', abbr: 'Sept' },
        { name: 'October', abbr: 'Oct' },
        { name: 'November', abbr: 'Nov' },
        { name: 'December', abbr: 'Dec' },
    ]

    /** --------------------------------------------
     * get a month by either its name or abbreviation
     */
    const getMonthsBy = (field: string = 'name') => {
        const data = []
        months.forEach((month) => {
            data.push(month[field] + (field === 'abbr' || field === 'abbreviation') ? '.' : '')
        })
        return data
    }

    return { months, getMonthsBy }
}
