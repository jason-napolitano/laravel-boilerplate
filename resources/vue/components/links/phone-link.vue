<template>
    <a :href="`tel:${props.phone}`" class="flex items-center text-blue-300 underline">
        <PhoneCall class="h-3.5" />
        <span>{{ props.text }}</span>
    </a>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { PhoneCall } from 'lucide-vue-next'

// --------------------------------------------------------
// props
const props = defineProps<{
    phone: string
    text: string
}>()
</script>
