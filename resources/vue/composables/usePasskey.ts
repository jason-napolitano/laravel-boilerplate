import { usePasskeyRegister } from '@laravel/passkeys/vue'
import { Passkeys } from '@laravel/passkeys'
import { router } from '@inertiajs/vue3'
import { Passkey } from '@/types'

export function usePasskey() {
    // --------------------------------------------
    // passkey name
    const passkeyName = ref('')

    // --------------------------------------------
    // formatted `last_used_date`
    const lastUsedAt = (passkey: Passkey, text: string = 'N/A') => {
        return computed(() => (passkey['last_used_at'] ? useDate().fromLaravelDate(passkey['last_used_at']) : text))
    }

    // --------------------------------------------
    // usePasskeyRegister() composable
    const { register } = usePasskeyRegister({
        onSuccess: () => {
            passkeyName.value = ''
            router.reload()
            ElNotification({
                type: 'success',
                message: 'Passkey registered successfully',
                position: 'bottom-right',
            })
        },
    })

    /** --------------------------------------------
     * register a passkey
     */
    const registerPasskey = async (event: Event, callback = null) => {
        event.preventDefault()
        if (!passkeyName.value.trim()) {
            return
        }
        await register(passkeyName.value)

        if (callback) callback()
    }

    /** --------------------------------------------
     * verify a passkey
     */
    async function verifyPasskey() {
        const response = await Passkeys.verify()

        if (response.redirect) {
            router.visit(response.redirect)
        }
    }

    /** --------------------------------------------
     * delete a passkey
     */
    const deletePasskey = (id: string | number) => {
        ElMessageBox.confirm('Are you sure you want to delete this passkey?', 'Continue?', {
            type: 'warning',
        }).then(() => {
            router.delete(route('passkey.destroy', id), {
                preserveScroll: true,
                onSuccess: () => {
                    ElNotification({
                        type: 'success',
                        message: 'Passkey deleted successfully',
                        position: 'bottom-right',
                    })
                },
            })
        })
    }

    return { registerPasskey, deletePasskey, verifyPasskey, passkeyName, lastUsedAt }
}
