<template>
    <div class="space-y-4">
        <div v-if="props.showTitle">{{ assigned.length }} / {{ permissions.length }} permissions are assigned to {{ props.user['name'] }}</div>

        <el-space>
            <div v-for="permission in permissions" :key="permission" class="flex w-full items-center justify-between gap-2">
                <span class="capitalize">
                    {{ permission }}
                </span>

                <el-switch
                    @change="togglePermission(permission, $event)"
                    :model-value="hasPermission(permission)"
                    :loading="pending.has(permission)"
                    :disabled="pending.has(permission)"
                    size="small"
                />
            </div>
        </el-space>
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { router } from '@inertiajs/vue3'
import { User } from '@/types'

// --------------------------------------------------------
// props
interface Props {
    assignedPermissions: string[]
    modelId: number | string
    permissions: string[]
    showTitle: boolean
    modelType: string
    user: User
}

const props = withDefaults(defineProps<Props>(), {
    showTitle: true,
})

const assigned = ref<string[]>([...props.assignedPermissions])
const pending = ref(new Set<string>())

watch(
    () => props.assignedPermissions,
    (value) => (assigned.value = [...value]),
)

const hasPermission = (permission: string) => {
    return assigned.value.includes(permission)
}

const togglePermission = (permission: string, granted: string | number | boolean) => {
    const enabled = granted as boolean

    if (pending.value.has(permission)) return

    const previouslyGranted = hasPermission(permission)

    // Optimistic UI update
    if (enabled && !previouslyGranted) {
        assigned.value.push(permission)
    } else if (!enabled && previouslyGranted) {
        assigned.value = assigned.value.filter((item) => item !== permission)
    }

    pending.value = new Set(pending.value).add(permission)

    router.patch(
        route('users.model-permissions.update', props.user['id']),
        {
            model_type: props.modelType,
            model_id: props.modelId,
            granted: enabled,
            permission,
        },
        {
            preserveScroll: true,
            preserveState: true,
            onError: () => {
                // Restore previous state
                if (previouslyGranted) {
                    if (!assigned.value.includes(permission)) {
                        assigned.value.push(permission)
                    }
                } else {
                    assigned.value = assigned.value.filter((item) => item !== permission)
                }
            },
            onFinish: () => {
                ElNotification.success({
                    message: 'Permission successfully updated',
                    position: 'bottom-right',
                    showClose: false,
                })

                const updated = new Set(pending.value)
                updated.delete(permission)
                pending.value = updated
            },
        },
    )
}
</script>
