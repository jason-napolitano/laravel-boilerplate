<template>
    <div class="flex flex-col gap-4">
        <el-collapse accordion class="border border-stone-200/75 dark:border-stone-700">
            <el-collapse-item v-for="(role, index) in props.roles" :title="ucFirst(role['name'])" :name="index">
                <div class="flex flex-col gap-2 border-t border-stone-200/75 pt-2 dark:border-stone-700">
                    <div class="flex justify-end px-2">
                        <el-button type="danger" :icon="Trash2" :disabled="role['name'] == ucFirst(env('DEFAULT_ROLE'))" @click="deleteRole(role)">
                            Delete Role
                        </el-button>
                    </div>
                    <div class="mx-2 grid grid-cols-12 gap-2">
                        <div class="group col-span-4 flex border border-stone-200 dark:border-stone-700" v-for="permission in props.permissions">
                            <div class="flex items-center border-r border-stone-200 bg-stone-100 px-2 dark:border-stone-700 dark:bg-stone-800">
                                <el-checkbox :checked="roleMatch(role, permission)" @click="addPermissionToRole(role, permission)" size="small" />
                            </div>

                            <div
                                v-text="toTitleCase(replace(permission['name'], '_', ' '))"
                                class="flex w-full items-center p-2 text-xs group-hover:bg-stone-50 dark:group-hover:bg-stone-900"
                            />
                        </div>
                    </div>
                </div>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { Permission, Role } from '@/types'
import { router } from '@inertiajs/vue3'
import { Trash2 } from 'lucide-vue-next'
import { ElNotification } from 'element-plus'

// --------------------------------------------------------
// props
const props = defineProps<{
    permissions: Permission[]
    roles: Role[]
}>()

// --------------------------------------------------------
// string composable
const { ucFirst, toTitleCase, replace } = useString()

// --------------------------------------------------------
// role management
const { roleMatch, addPermissionToRole, deleteRole } = useRole()

// env support
const { env } = useApp()
</script>
