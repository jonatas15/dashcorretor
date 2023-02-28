<template>
<div class="container text-left">
    <Bar :data="data" :options="options" />
</div>
</template>
<script lang="ts">
import {
Chart as ChartJS,
Title,
Tooltip,
Legend,
BarElement,
CategoryScale,
LinearScale
} from 'chart.js'
import { Bar } from 'vue-chartjs'
import * as chartConfig from './chartConfig.js'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

export default {
    name: 'Chart',
    components: {
        Bar
    },
    data() {
        return chartConfig
    }
}
</script>
<style>
.banner img {
    width: 100%;
}
</style>