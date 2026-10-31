<template>
    <dashboard-layout title="Manage Authorization">
        <template #headingRight>
            <el-button-group>
                <create-role />
                <!-- create-permission / -->
            </el-button-group>
        </template>
        <role-manager :roles="props.roles" :permissions="props.permissions" />
    </dashboard-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import CreatePermission from '@/components/forms/permissions/create.vue'
import RoleManager from '@/components/tables/role-manager.vue'
import CreateRole from '@/components/forms/roles/create.vue'

// --------------------------------------------------------
// component props
import { Permission, Role } from '@/types'

const props = defineProps<{
    permissions: Permission[]
    roles: Role[]
}>()
</script>
