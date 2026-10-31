<template>
    <header class="mb-4 flex items-center justify-between border-b border-b-stone-200 py-4">
        <!-- 'web' route -->
        <nav class="flex items-center gap-2">
            <ActiveLink href="welcome" pages="welcome"> Homepage </ActiveLink>
            <ActiveLink href="about" pages="about"> About Us </ActiveLink>
        </nav>

        <!-- 'guest' routes -->
        <Link :href="route('login')" v-if="!$page.props.auth.user">Authenticate </Link>

        <!-- 'verified' route -->
        <div class="flex items-center justify-end gap-2" v-else>
            <Link :href="route('dashboard')" v-if="can('view_dashboard')"> Dashboard </Link>
            <span class="cursor-pointer" @click="logout">Logout</span>
        </div>
    </header>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import ActiveLink from '@/components/links/active-link.vue'
import { Link } from '@inertiajs/vue3'

// --------------------------------------------------------
// auth actions
const { logout, can } = useAuth()
</script>
