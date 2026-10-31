import { SharedData, User } from '@/types'
import { router } from '@inertiajs/vue3'

export function useAuth() {
    // ---------------------------------------------
    // auth object
    const { auth } = usePage<SharedData>().props

    // ---------------------------------------------
    // is a user logged in?
    const loggedIn: boolean = !!auth.user

    /** --------------------------------------------
     * Is `user` the same user being passed through the
     * request pipeline
     */
    function isCurrentUser(user: User): boolean {
        return auth.user['id'] === user['id']
    }

    /** --------------------------------------------
     * Can a user perform a certain action (or actions)?
     */
    function can(permissions: string[] | string): boolean {
        // if the permissions prop passed by inertia is not
        // an empty array
        if (auth.permissions.length) {
            // generate an empty data array
            const data: string[] = []

            // add permission names to that array
            auth.permissions.forEach((prop: { name: string }) => {
                data.push(prop.name.toLowerCase())
            })

            // if `permissions` is a string
            if (typeof permissions === 'string') {
                // run this check
                return data.includes(permissions) || data.includes('*')
            }
            // otherwise, run this check
            return permissions.every((permission: string) => data.includes(permission)) || data.includes('*')
        }
        // if the permissions prop passed by inertia is not set
        // default to false
        return false
    }

    /** --------------------------------------------
     * Return the opposite of `can()`
     */
    function cannot(permissions: string[] | string): boolean {
        return !can(permissions)
    }

    /** --------------------------------------------
     * Is `user` the same user being passed through the
     * request pipeline, and can they perform a certain
     * action (or actions)?
     */
    function currentUserCan(user: User, permissions: string[] | string): boolean {
        return (can(permissions) && isCurrentUser(user)) || can('*')
    }

    /** --------------------------------------------
     * check a users' role
     */
    function hasRole(user: User, role: string): boolean {
        return user.roles[0]['name'] === role
    }

    /** --------------------------------------------
     * Reset Password action
     */
    function resetPassword(form) {
        form.post(route('password.update'), {
            onSuccess: () => {
                form.reset('password', 'password_confirmation')
                ElNotification({
                    type: 'success',
                    message: 'Password updated successfully',
                    position: 'bottom-right',
                })
            },
        })
    }

    /** --------------------------------------------
     * Forgot Password action
     */
    function forgotPassword(email: string) {
        router.post(
            route('password.request'),
            {
                email: email,
            },
            {
                onSuccess: () => {
                    ElNotification({
                        type: 'success',
                        message: 'Password reset link has been sent',
                        position: 'bottom-right',
                    })
                },
            },
        )
    }

    /** --------------------------------------------
     * Login action
     */
    function login(form) {
        form.post(route('login.store'), {
            onSuccess: () => {
                form.reset()
                ElNotification({
                    type: 'success',
                    message: "You've successfully logged in",
                    position: 'bottom-right',
                })
            },
        })
    }

    /** --------------------------------------------
     * Register action
     */
    function register(form) {
        form.post(route('register.store'), {
            onSuccess: () => {
                form.reset()
                ElNotification({
                    type: 'success',
                    message: "You've successfully registered",
                    position: 'bottom-right',
                })
            },
        })
    }

    /** --------------------------------------------
     * Logout action
     */
    function logout(): void {
        ElMessageBox.confirm('This action will terminate your current session. Continue?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }).then(() => {
            router.post(route('logout'))
        })
    }

    return { can, logout, isCurrentUser, loggedIn, currentUserCan, hasRole, login, resetPassword, forgotPassword, register, cannot }
}
