export function useDialog() {
    // ---------------------------------------------
    // is the dialog window open?
    const dialogOpen = ref<boolean>(false)

    // ---------------------------------------------
    // toggle dialog window
    const toggleDialog = () => {
        dialogOpen.value = !dialogOpen.value
    }

    return { dialogOpen, toggleDialog }
}
