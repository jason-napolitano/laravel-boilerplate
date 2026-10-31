<template>
    <el-collapse accordion>
        <ul class="mx-2 grid grid-cols-12 gap-4">
            <li
                class="col-span-12 flex items-center justify-between border-b border-stone-200 py-4 md:col-span-6 dark:border-stone-700"
                v-for="permission in props.permissions"
            >
                <div v-text="toTitleCase(replace(permission['name'], '_', ' '))" />
                <el-switch :active-value="permissionMatch(props.user, permission)" @click="updatePermission(props.user, permission)" />
            </li>
        </ul>
    </el-collapse>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { Permission, User } from '@/types'

// --------------------------------------------------------
// props
const props = defineProps<{
    permissions: Permission[]
    user: User
}>()

// --------------------------------------------------------
// string composable
const { toTitleCase, replace } = useString()

// --------------------------------------------------------
// permission management
const { updatePermission, permissionMatch } = usePermission()
</script>
