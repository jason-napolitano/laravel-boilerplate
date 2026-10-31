<template>
    <master-layout title="User Authentication">
        <auth-container>
            <auth-header />
            <auth-content>
                <slot />
            </auth-content>
        </auth-container>
        <auth-footer />
    </master-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import AuthContainer from './partials/auth/container.vue'
import AuthContent from './partials/auth/content.vue'
import AuthFooter from './partials/auth/footer.vue'
import AuthHeader from './partials/auth/header.vue'
import MasterLayout from '@/layouts/master.vue'
</script>
