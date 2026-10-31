<template>
    <master-layout :title="props.title">
        <app-container>
            <app-header />
            <app-content>
                <slot />
            </app-content>
            <app-footer />
        </app-container>
    </master-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import AppContainer from './partials/app/container.vue'
import AppContent from './partials/app/content.vue'
import AppFooter from './partials/app/footer.vue'
import AppHeader from './partials/app/header.vue'
import MasterLayout from '@/layouts/master.vue'
import { FunctionalComponent } from 'vue'

// --------------------------------------------------------
// props
interface AppLayoutProps {
    icon?: FunctionalComponent
    title?: string
}
const props = withDefaults(defineProps<AppLayoutProps>(), {
    icon: null,
    title: null,
})
</script>
