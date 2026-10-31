<template>
    <error-layout :title="`Error: ${status}`">
        <div class="flex items-center justify-center">
            <div class="flex flex-col gap-2 text-center">
                <div class="text-8xl font-bold" v-text="status" />
                <h1 class="mt-4 text-3xl font-semibold" v-text="title" />
                <p class="mt-2" v-text="description" />
            </div>
        </div>
    </error-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import ErrorLayout from '@/layouts/error.vue'

// --------------------------------------------------------
// props
const props = defineProps<{
    status: number
}>()

// --------------------------------------------------------
// error titles
const title = computed(() => {
    return (
        {
            403: 'Forbidden',
            404: 'Page Not Found',
            419: 'Page Expired',
            500: 'Internal Error',
            503: 'Service Unavailable',
        }[props.status] ?? 'Something went wrong'
    )
})

// --------------------------------------------------------
// error descriptions
const description = computed(() => {
    return (
        {
            403: "You don't have permission to access this resource.",
            404: "The page you're looking for doesn't exist.",
            419: 'The current page has expired.',
            500: 'There was an internal server error.',
            503: 'The requested service is unavailable',
        }[props.status] ?? 'An unexpected error occurred.'
    )
})
</script>
