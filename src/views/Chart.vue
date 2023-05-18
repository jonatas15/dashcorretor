<template>
<div class="container text-left">
    <Line :data="data" :options="options" />
</div>
</template>
<script lang="ts">
import { Chart as ChartJS, ArcElement, Tooltip, Legend, Title,
BarElement,
CategoryScale,
LinearScale, PointElement, LineElement } from 'chart.js';
import { Doughnut, Bar, Line } from 'vue-chartjs';

import moment from 'moment';


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
            meses: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
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

            
            var new_ticket_medio_venda = 0;
            var new_custo_lead = 0;

            var new_labels = [];
            var mesescontent = [];
            
            for(let mes of [1,2,3,4,5,6,7,8,9,10,11,12]) {
                var new_leadsrecebidos = 0;
                var new_percentual_conversao = 0;
                var new_quant_vendas_vgc = 0;
                var new_quant_vendas_vgv = 0;
                var new_quant_visitas = 0;
                var new_quant_imoveis_agenciados = 0;
                for(let mc of this.corretor.macros) {
                    if (mc.mes_referencia == mes) {
                        new_leadsrecebidos += mc.leads_recebidos;
                        new_percentual_conversao += Number(mc.percentual_conversao);
                        new_quant_vendas_vgc += mc.quant_vendas_vgc;
                        new_quant_vendas_vgv += mc.quant_vendas_vgv;
                        new_quant_visitas += mc.quant_visitas;
                        new_quant_imoveis_agenciados += mc.quant_imoveis_agenciados;
                        // Manda para os array
                    }
                    
                }
                if (
                    new_leadsrecebidos > 0 ||
                    new_percentual_conversao > 0 ||
                    new_quant_vendas_vgc > 0 ||
                    new_quant_vendas_vgv > 0 ||
                    new_quant_visitas > 0 ||
                    new_quant_imoveis_agenciados > 0
                ) {

                    this.corretorlabels.push(this.meses[Number(mes-1)]);
                    leadsrecebidos.push(new_leadsrecebidos);
                    percentual_conversao.push(new_percentual_conversao);
                    quant_vendas_vgc.push(new_quant_vendas_vgc);
                    quant_vendas_vgv.push(new_quant_vendas_vgv);
                    quant_visitas.push(new_quant_visitas);
                    quant_imoveis_agenciados.push(new_quant_imoveis_agenciados);
                }
            }
            // console.log(new_labels);
            // console.log(leadsrecebidos);

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
                label: "Vendas VGC",
                backgroundColor: 'darkgreen',
                borderColor: 'darkgreen',
                data: quant_vendas_vgc,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            this.corretormacros.push({
                label: "Vendas VGV",
                backgroundColor: 'lawngreen',
                borderColor: 'lawngreen',
                data: quant_vendas_vgv,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            this.corretormacros.push({
                label: "Vsitas",
                backgroundColor: 'greenyellow',
                borderColor: 'greenyellow',
                data: quant_visitas,
                fill: false,
                borderWidth: borderlinhagrafico,
                pointStyle: 'point',
                pointRadius: 4
            });
            this.corretormacros.push({
                label: "Imóveis agenciados",
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