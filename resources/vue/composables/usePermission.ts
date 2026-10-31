import { Permission, User } from '@/types'
import { router } from '@inertiajs/vue3'

export function usePermission() {
    /** --------------------------------------------
     * Check is a user has a permission
     */
    const permissionMatch = (user: User, permission: Permission): boolean => {
        let data = []
        user.permissions.forEach((permission: Permission) => {
            data.push(permission['name'])
        })

        return !data.includes(permission['name'])
    }

    /** --------------------------------------------
     * Update a permission
     */
    const updatePermission = (user: User, permission: Permission): void => {
        router.patch(
            route('users.permissions.update', user),
            {
                permission: permission,
            },
            {
                onSuccess: () => {
                    ElNotification.success({
                        message: 'Permission successfully updated',
                        position: 'bottom-right',
                        showClose: false,
                    })
                },
            },
        )
    }

    return { updatePermission, permissionMatch }
}
