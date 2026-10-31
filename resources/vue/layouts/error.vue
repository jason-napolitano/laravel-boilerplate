<template>
    <master-layout :title="props.title">
        <error-container>
            <error-content>
                <slot />
            </error-content>
            <error-footer />
        </error-container>
    </master-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import ErrorContainer from './partials/error/container.vue'
import ErrorContent from './partials/error/content.vue'
import ErrorFooter from './partials/error/footer.vue'
import MasterLayout from '@/layouts/master.vue'

// --------------------------------------------------------
// props
const props = withDefaults(
    defineProps<{
        title: string
    }>(),
    {
        title: 'Error Encountered',
    },
)
</script>
