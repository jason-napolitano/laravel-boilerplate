<template>
    <div class="flex flex-col gap-2">
        <div class="flex justify-center gap-2">
            <span v-text="props.label"></span>
            <span v-if="props.showCount">({{ count }})</span>
        </div>
        <BarChart v-bind="barChartProps" :options="chartOptions" css-classes="border border-stone-200 p-2" />
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { BarChart, useBarChart } from 'vue-chart-3'
import { Chart, registerables } from 'chart.js'

// --------------------------------------------------------
// props
const props = withDefaults(
    defineProps<{
        maintainAspectRatio?: boolean
        initialData: number[]
        responsive?: boolean
        showCount?: boolean
        showLegend?: boolean
        colors?: string[]
        labels: string[]
        label: string
    }>(),
    {
        maintainAspectRatio: false,
        showLegend: false,
        responsive: true,
        showCount: false,
        colors: [],
    },
)

// --------------------------------------------------------
// chart registration
Chart.register(...registerables)

// --------------------------------------------------------
// random hex codes
const { randomHexCodes } = useMarkup()

// --------------------------------------------------------
// chart options
const chartOptions = {
    maintainAspectRatio: props.maintainAspectRatio,
    responsive: props.responsive,
    plugins: {
        legend: {
            display: props.showLegend,
        },
    },
}

// --------------------------------------------------------
// chart data
const data = ref(props.initialData)

const chartData = computed(() => ({
    labels: props.labels,
    datasets: [
        {
            data: data.value,
            backgroundColor: randomHexCodes(props.initialData.length, props.colors),
            label: props.label,
        },
    ],
}))

const { barChartProps } = useBarChart({
    chartData,
})

// --------------------------------------------------------
// data count
const count = ref(props.initialData.reduce((accumulator, currentValue) => accumulator + currentValue, 0))
</script>
