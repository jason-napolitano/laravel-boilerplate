<template>
    <dashboard-layout title="Manage Settings">
        <div class="grid grid-cols-12 space-x-4">
            <div class="col-span-3">
                <div class="border-b border-stone-200 pb-2 text-lg dark:border-stone-600">Application Logo</div>
                <update-logo
                    :can-update="can('update_app_logo')"
                    upload-route="settings.update-logo"
                    button-text="Update Logo"
                    :model="props.settings"
                    :can-delete="false"
                    column="logo"
                    field="logo"
                />
            </div>
            <div class="col-span-9">
                <update-settings :settings="props.settings" />
            </div>
        </div>
    </dashboard-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import UpdateSettings from '@/components/forms/settings/update.vue'
import UpdateLogo from '@/components/media/image.vue'
import { Settings } from '@/types'

// --------------------------------------------------------
// auth check
const { can } = useAuth()

// --------------------------------------------------------
// component props
const props = defineProps<{
    settings: Settings
}>()
</script>
