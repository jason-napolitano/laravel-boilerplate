<template>
    <dashboard-layout title="Manage Users">
        <template #headingRight v-if="can('create_user')">
            <create-user-form :roles="props.roles" />
        </template>

        <el-tabs type="border-card" v-model="byQueryParam">
            <el-tab-pane label="Active Users" name="active">
                <user-table :users="props.users" />
            </el-tab-pane>
            <el-tab-pane label="Banned Users" v-if="can('manage_banned_users')" name="banned">
                <user-table :users="props.bannedUsers" />
            </el-tab-pane>
        </el-tabs>
    </dashboard-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import CreateUserForm from '@/components/forms/users/create.vue'
import UserTable from '@/components/tables/users.vue'
import { PaginatedUsers, Role } from '@/types'

// --------------------------------------------------------
// component props
const props = defineProps<{
    bannedUsers: PaginatedUsers
    users: PaginatedUsers
    roles: Role[]
}>()

// --------------------------------------------------------
// auth check
const { can } = useAuth()

// --------------------------------------------------------
// tab based routing
const { byQueryParam } = useTabs('active', 'status')
</script>
