import { router } from '@inertiajs/vue3'
import { User } from '@/types'

export function useUser() {
    /** --------------------------------------------
     * Delete a user from storage
     */
    const deleteUser = (user: User) => {
        ElMessageBox.confirm('Are you sure you want to delete this user?', 'Continue?', {
            type: 'warning',
        }).then(() => {
            router.delete(route('users.destroy', user), {
                onSuccess: () => {
                    ElNotification({
                        type: 'success',
                        message: 'The user has been deleted',
                        position: 'bottom-right',
                    })
                },
            })
        })
    }

    /** --------------------------------------------
     * Ban a user
     */
    const banUser = (user: User) => {
        ElMessageBox.confirm(`Are you sure you want to ${user.is_banned ? 'un-ban' : 'ban'} this user?`, 'Continue?', {
            type: 'warning',
        }).then(() => {
            router.post(
                route('users.ban', user),
                {},
                {
                    onSuccess: () => {
                        ElNotification({
                            type: 'success',
                            message: `The user has been ${user.is_banned ? 'un-banned' : 'banned'}`,
                            position: 'bottom-right',
                        })
                    },
                },
            )
        })
    }

    return { deleteUser, banUser }
}
