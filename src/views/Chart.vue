<template>
<div class="container text-left">
    <Line :data="data" :options="options" />
</div>
</template>
<script lang="ts">
import { Chart as ChartJS, ArcElement, Tooltip, Legend, Title,
BarElement,
CategoryScale,
LinearScale, PointElement, LineElement } from 'chart.js'
import { Doughnut, Bar, Line } from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, BarElement, ArcElement, Tooltip, Legend, PointElement, LineElement)


export default {
    name: 'Chart',
    components: {
        Doughnut,
        Bar,
        Line
    },
    data() {
        return {
            varcorretor: [],
            corretor: [],
            corretorlabels: [],
            corretormacros: [],
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr'],
                datasets: [
                    {
                        label: "Leads",
                        backgroundColor: '#e3e3e3',
                        borderColor: '#e3e3e3',
                        data: [33, 78, 34, 67],
                        fill: false,
                    },
                    {
                        label: "Bla",
                        backgroundColor: '#2d460b',
                        borderColor: '#2d460b',
                        data: [44, 34, 45, 33],
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                legend: {
                    display: false
                }
            }
        }
    },
    methods: {
        retornames (recebido) {
            let mes = [
                'janeiro', 'fevereiro', 'março', 'abril',
                'maio', 'junho', 'julho', 'agosto', 'setembro',
                'outubro', 'novembro', 'dezembro'
            ][recebido - 1];
            return mes;
        }
    },
    created() {
        if (localStorage.getItem('authUser')) {
            this.varcorretor = localStorage.getItem('authUser');
            this.corretor = JSON.parse(this.varcorretor);
            // console.log(this.corretor.macros);

            var leadsrecebidos = [];
            var percentual_conversao = [];
            var quant_vendas_vgc = [];
            var quant_vendas_vgv = [];
            var quant_visitas = [];
            var quant_imoveis_agenciados = [];

            for(let mc of this.corretor.macros) {
                this.corretorlabels.push(this.retornames(mc.mes_referencia));
                for(let mc2 of this.corretor.macros) {
                    leadsrecebidos.push(mc2.leads_recebidos);
                    percentual_conversao.push(mc2.percentual_conversao);
                    quant_vendas_vgc.push(mc2.quant_vendas_vgc);
                    quant_vendas_vgv.push(mc2.quant_vendas_vgv);
                    quant_visitas.push(mc2.quant_visitas);
                    quant_imoveis_agenciados.push(mc2.quant_imoveis_agenciados);
                }
            }

            var borderlinhagrafico = 0.8;

            this.corretormacros.push({
                label: "Leads Recebidos",
                backgroundColor: 'green',
                borderColor: 'green',
                data: leadsrecebidos,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            this.corretormacros.push({
                label: "Percentual de Conversão",
                backgroundColor: 'lime',
                borderColor: 'lime',
                data: percentual_conversao,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            this.corretormacros.push({
                label: "Q. Vendas VGC",
                backgroundColor: 'darkgreen',
                borderColor: 'darkgreen',
                data: quant_vendas_vgc,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            this.corretormacros.push({
                label: "Q. Vendas VGV",
                backgroundColor: 'lawngreen',
                borderColor: 'lawngreen',
                data: quant_vendas_vgv,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            this.corretormacros.push({
                label: "Q. Vsitas",
                backgroundColor: 'greenyellow',
                borderColor: 'greenyellow',
                data: quant_visitas,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            this.corretormacros.push({
                label: "Q. Imóveis agenciados",
                backgroundColor: 'olive',
                borderColor: 'olive',
                data: quant_imoveis_agenciados,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            // console.log("meses");
            // console.log(this.corretorlabels);
            this.data.labels = this.corretorlabels;
            this.data.datasets = this.corretormacros;

        }
    },
}
  

</script>
<style>
.banner img {
    width: 100%;
}
</style>