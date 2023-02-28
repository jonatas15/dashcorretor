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
        ChartJS,
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
    },
    mounted() {
        this.addPlugin({
            id: 'my-plugin',
            beforeDraw: function(chart) {}
        })
        this.renderChart(this.data, this.options)
        this.textCenter(880)
    },
    methods: {
        textCenter(val) {
            this.Chart.pluginService.register({
                beforeDraw: function(chart) {
                    var width = chart.chart.width
                    var height = chart.chart.height
                    var ctx = chart.chart.ctx

                    ctx.restore()
                    var fontSize = (height / 114).toFixed(2)
                    ctx.font = fontSize + "em sans-serif"
                    ctx.textBaseline = "middle"

                    var text = val;
                    var textX = Math.round((width - ctx.measureText(text).width) / 2)
                    var textY = height / 2

                    ctx.fillText(text, textX, textY)
                    ctx.save()
                }
            })

            this.Chart.plugins.unregister(this.chartdata)
        }
    }
}
  

</script>
<style>
.banner img {
    width: 100%;
}
</style>