<template>
    <div class="text-primary flex cursor-pointer items-center gap-1 underline" @click="toggleFilters(props.filter, props.data, props.href)">
        <Funnel class="h-4" v-if="props.icon" />
        <span v-text="props.text" />
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { Funnel } from 'lucide-vue-next'

// --------------------------------------------------------
// props
interface ComponentProps {
    text?: string
    filter: string
    data: string | number
    href?: string
    icon?: boolean
}

const props = withDefaults(defineProps<ComponentProps>(), {
    text: null,
    href: null,
    icon: true,
})

// --------------------------------------------------------
// filter toggling
const { toggleFilters } = useRoute()
</script>
