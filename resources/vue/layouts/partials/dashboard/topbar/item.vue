<template>
    <Link :href="route(props.href, props.data ?? [])" class="hover:bg-primary flex items-center">
        <props.icon class="mb-0.5 h-3.5" />
        <span> {{ props.label }}</span>
    </Link>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports

// --------------------------------------------------------
// component props
import { FunctionalComponent } from 'vue'

interface ItemProps {
    icon?: FunctionalComponent
    href?: string
    label: string
    data?: any
}

const props = withDefaults(defineProps<ItemProps>(), {
    data: null,
    icon: null,
})

// --------------------------------------------------------
// active class styling
const { activeClass } = useMarkup()
</script>

<style scoped>
/* --- */
</style>
