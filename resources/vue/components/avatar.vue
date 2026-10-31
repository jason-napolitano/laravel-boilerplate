<template>
    <img :src="props.user['avatar']" alt="" class="h-8 w-8 rounded-full" />
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { User } from '@/types'

// --------------------------------------------------------
// props
const props = withDefaults(defineProps<{ user?: User }>(), {
    user: null,
})
</script>
