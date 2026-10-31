<template>
    <header class="flex h-16 items-center justify-end gap-2 border-b border-stone-200 px-4 dark:border-stone-700 dark:text-slate-50">
        <topbar-item v-if="can('manage_settings')" label="Manage Settings" :icon="Settings" href="settings.index" />
        <topbar-item
            v-if="can('view_profile')"
            :label="$page.props.auth.user.name"
            :data="$page.props.auth.user"
            :icon="CircleUserRoundIcon"
            href="users.show"
        />
    </header>
</template>

<script setup>
// --------------------------------------------------------
// imports
import { CircleUserRoundIcon, User, KeySquare, Settings } from 'lucide-vue-next'
import TopbarItem from './topbar/item.vue'

// --------------------------------------------------------
// auth check
const { can } = useAuth()
</script>
