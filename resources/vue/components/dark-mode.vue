<template>
    <span @click="toggleDarkMode()" class="cursor-pointer">
        <slot> Toggle {{ isDark ? 'Light' : 'Dark' }} Mode </slot>
    </span>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// composables
const { isDark, toggleDarkMode } = useDarkMode()
</script>
