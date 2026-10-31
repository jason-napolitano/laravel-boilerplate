<template>
    <aside class="flex flex-col justify-between border-r border-stone-200 transition-all duration-200 sm:w-16 md:flex md:w-28 dark:border-stone-700">
        <div class="flex flex-col">
            <Link
                class="flex h-16 flex-col items-center justify-center border-b border-stone-200 bg-[#F5F7FA] text-2xl font-thin dark:border-stone-700 dark:bg-stone-600/85 dark:text-slate-50"
                :href="route('welcome')"
            >
                <span>{{ getInitials($page.props.settings['title']) }}</span>
            </Link>

            <nav class="flex-1 space-y-1 px-2 pt-2">
                <item label="Dashboard" href="dashboard" pages="dashboard" :icon="GaugeCircle" v-if="can('view_dashboard')" />
                <item label="Users" href="users.index" pages="users.*" :icon="Users" v-if="can('manage_users')" />
                <item label="Authorization" href="roles.index" pages="roles.*" :icon="KeySquare" v-if="can('manage_roles')" />
            </nav>
        </div>
        <div class="text-center">v.{{ $page.props.settings['version'] }}</div>
    </aside>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { GaugeCircle, Users, KeySquare, Settings } from 'lucide-vue-next'
import Item from './sidebar/item.vue'

// --------------------------------------------------------
// auth check
const { can } = useAuth()

// --------------------------------------------------------
// env variables
const { env } = useApp()

// --------------------------------------------------------
// application initials
const { getInitials } = useInitials()
</script>
