<template>
    <div class="flex flex-wrap gap-1">
        <template v-for="(link, index) in props.links" :key="index">
            <!-- Disabled -->
            <span v-if="link.url === null" v-html="link.label" class="rounded px-3 py-1 text-gray-400" />

            <!-- Active -->
            <span v-else-if="link.active" v-html="link.label" class="bg-primary rounded-full p-3 py-1 text-sky-300" />

            <!-- Clickable -->
            <Link
                class="hover:text-primary rounded-full px-3 py-1 hover:bg-zinc-100 first:hover:bg-transparent last:hover:bg-transparent"
                v-html="link.label"
                :href="link.url"
                preserve-scroll
                preserve-state
                v-else
            />
        </template>
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { PaginationLink } from '@/types'

// --------------------------------------------------------
// props
const props = defineProps<{
    links: PaginationLink[]
}>()
</script>
