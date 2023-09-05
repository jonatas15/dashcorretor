<template>
    <div class="lh-lg" style="height: 400px;">
      <Bar :data="mudagrafico" :options="chartOptions"></Bar>
      <!-- {{ mudagrafico }} -->
    </div>
  </template>
  
  <script lang="ts">
  import {
    Chart as ChartJS, ArcElement, Tooltip, Legend, Title,
    BarElement,
    CategoryScale,
    LinearScale, PointElement, LineElement 
  } from 'chart.js';
  import { Bar } from 'vue-chartjs';
  ChartJS.register(CategoryScale, LinearScale, BarElement, ArcElement, Tooltip, Legend, PointElement, LineElement);
  import axios from "axios";
  
  export default {
    data() {
      return {
        visitas: [],
        corretores: [],
        corretoresdata: [],
        chartData: {
          labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set'],
          datasets: [
            {
              label: 'Corretor A',
              backgroundColor: '#FF5733',
              data: [10, 15, 20, 12, 18, 25, 33, 22, 18],
            },
            {
              label: 'Corretor B',
              backgroundColor: '#33FF57',
              data: [15, 10, 22, 14, 20, 28, 22, 12, 11],
            },
            {
              label: 'Corretor C',
              backgroundColor: '#5733FF',
              data: [8, 12, 18, 10, 16, 22, 11, 22, 19],
            },
          ],
        },
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              stacked: false,
            },
            y: {
              stacked: false,
            },
          },
        },
      };
    },
    components: {
        Bar
    },
    computed: {
        mudagrafico: function() {
            var corrs = [];
            
            for(let corretor of this.corretores) {
                if (corretor.ativo == 1) {

                    var visitas_por_mes = [];
                    var cor_graphic = 'blue';
                    for (let mes of this.chartData.labels) {
                        var contagem = 0;
                        for (let visita of this.visitas) {
                            if (visita.mes == mes && visita.id_corretor == corretor.idsistema) {
                                contagem++;
                                cor_graphic = visita.cor;
                            }
                        }
                        visitas_por_mes.push(contagem);
                    }
                    // console.log(visitas_por_mes);
                    corrs.push({
                        label: corretor.nome,
                        backgroundColor: cor_graphic,
                        data: visitas_por_mes
                    });
                }
            }
            return {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro'],
                datasets: corrs
            }
        }
    },
    created() {
        //   this.renderChart(this.chartData, this.chartOptions);
        // this.visitas
        axios.get('https://www.cafeimobiliaria.com.br/sistema/api/visita').then((res) => {
            // console.log(res.data)
            this.visitas = res.data.filter(
            d => d.id_corretor !== "" &&
                d.id_corretor !== null &&
                d.data_visita.indexOf("2023") !== -1
            );
            
            
        });
        axios.get('https://www.cafeimobiliaria.com.br/dadoscorretor/api/corretor').then((response) => {
            this.corretores = response.data;
            console.log(this.corretores)
        });
    }
  };
  </script>
  