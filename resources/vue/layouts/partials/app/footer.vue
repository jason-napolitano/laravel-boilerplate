<template>
    <footer class="mt-4 flex items-center justify-end gap-4 border-t border-t-stone-200 pt-4">
        <slot>
            <p>© {{ currentYear }} {{ env('NAME') }}. All rights reserved.</p>
        </slot>
    </footer>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import FooterItem from './footer/item.vue'

// --------------------------------------------------------
// year formatting
const { currentYear } = useDate()

// --------------------------------------------------------
// env variable
const { env } = useApp()
</script>
