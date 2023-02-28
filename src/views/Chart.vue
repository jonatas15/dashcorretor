<template>
<div class="container text-left">
    <Doughnut :data="data" :options="options" />
</div>
</template>
<script lang="ts">
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Doughnut } from 'vue-chartjs'

ChartJS.register(ArcElement, Tooltip, Legend)


export default {
    name: 'Chart',
    components: {
        Doughnut
    },
    data() {
        return {
            data: {
                labels: ['Leads recebidos', 'Não recebidos'],
                datasets: [
                    {
                        backgroundColor: ['#e3e3e3', '#2d460b'],
                        data: [33, 78],
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                }
            }
        }
    }
}
  

</script>
<style>
.banner img {
    width: 100%;
}
</style>