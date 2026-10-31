<template>
    <Link :href="route(props.href, props.data)" class="flex items-center gap-1 text-blue-300 underline">
        <FileSymlink class="h-4" v-if="props.icon" />
        <slot v-if="!props.text" />
        <span v-text="props.text" v-else />
    </Link>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { FileSymlink } from 'lucide-vue-next'

// --------------------------------------------------------
// props
interface ComponentProps {
    href: string
    data?: object
    text?: string
    icon?: boolean
}

const props = withDefaults(defineProps<ComponentProps>(), {
    data: null,
    text: null,
    icon: true,
})
</script>
