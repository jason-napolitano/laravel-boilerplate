<template>
    <dashboard-layout title="Show Category">
        <div class="space-y-4">
            <h1>{{ props.model['name'] }}</h1>
            <el-table :data="props.users" v-if="can('managePermissions')">
                <el-table-column label="Name" prop="name" />
                <el-table-column>
                    <template #default="scope">
                        <div class="text-right">
                            <permission-manager
                                :assigned-permissions="scope.row.assignedPermissions"
                                :model-id="props.model['id']"
                                :permissions="props.permissions"
                                model-type="category"
                                :show-title="false"
                                :user="scope.row"
                            />
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <pagination :links="props.users['links']" />
        </div>
    </dashboard-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import PermissionManager from '@/components/auth/toggle-model-permissions.vue'
import { PaginateData, DatabaseRecord, User } from '@/types'
import Pagination from '@/components/pagination.vue'

// --------------------------------------------------------
// component props
interface Category extends DatabaseRecord {
    name: string
}

const props = defineProps<{
    users: PaginateData
    model: Category
    permissions: []
}>()

// --------------------------------------------------------
// auth check
const { can } = useAuth()
</script>

<style scoped>
/* --- */
</style>
