<template>
    <Link :href="route(props.href)">
        {{ props.text }}
    </Link>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// props
interface FooterProps {
    text: string
    href: string
}

const props = defineProps<FooterProps>()
</script>
