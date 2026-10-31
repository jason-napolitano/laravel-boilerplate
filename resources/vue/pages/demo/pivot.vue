<template>
    <!--
    <dashboard-layout title="Dashboard">
        <div class="flex flex-col gap-4">
            <div class="flex gap-4" v-show="true">
                <el-select v-model="rendererName">
                    <el-option v-for="option in rendererOptions" :value="option" :label="option" />
                </el-select>
                <el-select v-model="aggregatorName">
                    <el-option v-for="option in aggregatorOptions" :value="option" :label="option" />
                </el-select>
                <el-checkbox v-model="showColTotal">Show Column Totals?</el-checkbox>
                <el-checkbox v-model="showRowTotal">Show Row Totals?</el-checkbox>
            </div>
            <vue-pivottable
                :hidden-attributes="hiddenAttributes"
                :rows="['Month Created']"
                :cols="['Year Created']"
                :data="data"
                :aggregator-name
                :show-col-total
                :show-row-total
                :renderer-name
                :renderers
            />
        </div>
    </dashboard-layout>
    -->
</template>

<script setup>
/*
import { VuePivottable, VuePivottableUi, Renderer } from 'vue-pivottable'
import LazyRenderer from '@vue-pivottable/lazy-table-renderer'
import PlotlyRenderer from '@vue-pivottable/plotly-renderer'
import 'vue-pivottable/dist/vue-pivottable.css'
import { useTableStore } from '@/stores/usePivotTable.ts'

// Add lazy table renderer to default renderers
const renderers = markRaw({ ...Renderer, ...LazyRenderer, ...PlotlyRenderer })

const props = defineProps({
    users: Array,
})

// customization
const { aggregatorName, rendererName, showColTotal, showRowTotal } = storeToRefs(useTableStore())
const { aggregatorOptions, rendererOptions } = useTableStore()

// custom labeling
const data = props.users.map((user) => ({
    'Month Created': user.month_created,
    'Year Created': user.year_created,
}))

// hidden
const hiddenAttributes = [
    'email_verified_at',
    'created_at',
    'updated_at',
    'deleted_at',
    'biography',
    'username',
    'website',
    'avatar',
    'email',
    'name',
    'id',
]
*/
</script>
