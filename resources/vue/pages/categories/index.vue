<template>
    <dashboard-layout title="Categories">
        <div class="flex flex-col gap-2">
            <Link :href="route('categories.show', category)" v-for="category in props.categories">
                {{ category['name'] }}
            </Link>
        </div>
    </dashboard-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { DatabaseRecord } from '@/types'
import { Link } from '@inertiajs/vue3'

// --------------------------------------------------------
// component props
interface Category extends DatabaseRecord {
    name: string
}

const props = defineProps<{
    categories: Category[]
}>()

// --------------------------------------------------------
// composables
</script>
