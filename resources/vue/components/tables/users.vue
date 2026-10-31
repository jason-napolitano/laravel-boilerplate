<template>
    <div class="flex flex-col gap-4">
        <el-table :data="props.users['data']">
            <el-table-column label="Basic Information">
                <el-table-column prop="name" label="Name" />
                <el-table-column label="Username">
                    <template #default="scope">
                        <page-link href="users.show" :text="scope.row.username" :data="scope.row" />
                    </template>
                </el-table-column>
                <el-table-column label="Email Address">
                    <template #default="scope">
                        <email-link :text="scope.row.email" :email="scope.row.email" />
                    </template>
                </el-table-column>
                <el-table-column label="Role" v-if="props.showRole">
                    <template #default="scope">
                        {{ ucFirst(scope.row.roles[0]['name']) }}
                    </template>
                </el-table-column>
            </el-table-column>

            <el-table-column label="Chronology">
                <el-table-column prop="created_at" label="Created At" />
                <el-table-column prop="updated_at" label="Updated At" />
            </el-table-column>

            <el-table-column v-if="can('delete_user') || can('ban_user')">
                <template #header>
                    <div class="text-center">Actions</div>
                </template>
                <el-table-column width="75" v-if="can('delete_user')">
                    <template #header>
                        <div class="text-center">Delete</div>
                    </template>
                    <template #default="scope">
                        <el-button
                            :disabled="hasRole(scope.row, 'admin') || scope.row.is_banned"
                            @click="deleteUser(scope.row)"
                            :icon="Trash2"
                            class="w-full"
                            type="danger"
                        />
                    </template>
                </el-table-column>
                <el-table-column width="75" v-if="can('ban_user')">
                    <template #header>
                        <div class="text-center">Ban</div>
                    </template>
                    <template #default="scope">
                        <el-button class="w-full" :icon="Ban" @click="banUser(scope.row)" :disabled="hasRole(scope.row, 'admin')" />
                    </template>
                </el-table-column>
            </el-table-column>
        </el-table>

        <div class="flex justify-center">
            <pagination :links="props.users['links']" />
        </div>
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import EmailLink from '@/components/links/email-link.vue'
import PageLink from '@/components/links/page-link.vue'
import Pagination from '@/components/pagination.vue'
import { Ban, Trash2 } from 'lucide-vue-next'
import { PaginatedUsers } from '@/types'

// --------------------------------------------------------
// component props
const props = withDefaults(
    defineProps<{
        users: PaginatedUsers
        showRole?: boolean
    }>(),
    {
        showRole: true,
    },
)

// --------------------------------------------------------
// string composable
const { ucFirst } = useString()

// --------------------------------------------------------
// auth check
const { can, hasRole } = useAuth()

// --------------------------------------------------------
// user actions
const { deleteUser, banUser } = useUser()
</script>
