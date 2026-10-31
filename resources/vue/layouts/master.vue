<template>
    <Head :title="`${$page.props.settings['title']} - ${props.title}`" />
    <slot />

    <DarkMode v-show="false" />
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import DarkMode from '@/components/dark-mode.vue'

// --------------------------------------------------------
// props
interface AppLayoutProps {
    title?: string | null
}
const props = withDefaults(defineProps<AppLayoutProps>(), {
    title: null,
})
</script>
