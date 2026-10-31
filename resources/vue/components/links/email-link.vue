<template>
    <a :href="`mailto:${props.email}`" class="flex items-center text-blue-300 underline">
        <MailPlus class="h-4" v-if="props.showIcon" />
        <span v-text="props.text" />
    </a>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { MailPlus } from 'lucide-vue-next'

// --------------------------------------------------------
// props
const props = withDefaults(
    defineProps<{
        showIcon?: boolean
        email: string
        text: string
    }>(),
    {
        showIcon: true,
    },
)
</script>
