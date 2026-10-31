<template>
    <Link :class="activeClass(props.pages, props.activeClass)" :href="route(props.href, props.data)">
        <slot />
    </Link>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// props
const props = withDefaults(
    defineProps<{
        activeClass?: string
        pages: string
        href: string
        data?: any
    }>(),
    {
        activeClass: 'text-primary underline',
        data: () => {},
    },
)

// --------------------------------------------------------
// composables
const { activeClass } = useMarkup()
</script>
