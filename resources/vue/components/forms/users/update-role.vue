<template>
    <el-dropdown trigger="click" placement="bottom-end" v-if="can('manage_roles')">
        <el-button :icon="RoleIcon" :disabled="isCurrentUser(props.user)">
            {{ ucFirst(props.user.roles[0]['name']) }}
        </el-button>
        <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item v-for="role in props.roles" v-text="ucFirst(role['name'])" @click="updateRole(role)" />
            </el-dropdown-menu>
        </template>
    </el-dropdown>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { KeySquare as RoleIcon } from 'lucide-vue-next'
import type { User, Role } from '@/types'
import { router } from '@inertiajs/vue3'

// --------------------------------------------------------
// component props

const props = defineProps<{
    roles: Role[]
    user: User
}>()

// --------------------------------------------------------
// auth check
const { can, isCurrentUser } = useAuth()

// --------------------------------------------------------
// string manipulation
const { ucFirst, plural } = useString()

// --------------------------------------------------------
// update action
const updateRole = (role: Role) => {
    router.patch(
        route('users.role.update', props.user),
        { role },
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
</script>
