<template>
    <dashboard-layout title="Dashboard">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6">
                <chart :initial-data="props.registrations" label="Registrations / Month" />
            </div>
            <div class="col-span-6">
                <chart :initial-data="props.logins" label="Logins / Month" />
            </div>
        </div>
    </dashboard-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import Chart from './partials/chart.vue'

// --------------------------------------------------------
// props
const props = defineProps<{
    registrations: number[]
    logins: number[]
}>()
</script>
