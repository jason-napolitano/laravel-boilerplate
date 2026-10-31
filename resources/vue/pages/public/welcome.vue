<template>
    <app-layout title="Welcome page">
        <h1>Welcome, {{ name }}</h1>
    </app-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { SharedData } from '@/types'

// --------------------------------------------------------
// page data
const page = usePage<SharedData>()

// --------------------------------------------------------
// user data
const { loggedIn } = useAuth()

// --------------------------------------------------------
// computed data
const name = computed(() => (loggedIn ? page.props.auth.user['name'] : 'Guest'))
</script>
