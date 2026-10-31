<template>
    <footer class="border-t border-stone-200 pt-4">
        <el-button @click="router.visit(route('welcome'))" class="w-full" size="default" :icon="House"> Go Home </el-button>
    </footer>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { router } from '@inertiajs/vue3'
import { House } from 'lucide-vue-next'
</script>
