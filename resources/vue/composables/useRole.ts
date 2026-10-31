import { Permission, Role } from '@/types'
import { router } from '@inertiajs/vue3'

export function useRole() {
    /** --------------------------------------------
     * Check if a role has a permission
     */
    const roleMatch = (role: Role, permission: Permission): boolean => {
        let data = []
        role.permissions.forEach((permission: Permission) => {
            data.push(permission['name'])
        })

        return data.includes(permission['name'])
    }

    /** --------------------------------------------
     * Add a permission to a role
     */
    const addPermissionToRole = (role: Role, permission: Permission): void => {
        router.post(
            route('roles.add-permission', role),
            {
                permission: permission,
            },
            {
                onSuccess: () => {
                    ElNotification.success({
                        message: 'Role successfully updated',
                        position: 'bottom-right',
                        showClose: false,
                    })
                },
            },
        )
    }

    /** --------------------------------------------
     * Delete a role from storage
     */
    const deleteRole = (role: Role): void => {
        ElMessageBox.confirm('Are you sure you want to permanently delete this role?', 'Continue?', {
            type: 'warning',
        }).then(() => {
            router.delete(route('roles.destroy', role), {
                onSuccess: () => {
                    ElNotification.success({
                        message: 'Role successfully deleted',
                        position: 'bottom-right',
                        showClose: false,
                    })
                },
            })
        })
    }

    return { roleMatch, addPermissionToRole, deleteRole }
}
