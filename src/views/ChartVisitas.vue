<template>
  <div class="row">
    <div class="col-12">
      <div class="" style="height: 400px;">
        <Bar :data="mudagrafico" :options="chartOptions" :width="'100%'"></Bar>
        <!-- Estágio: {{ estagio }} -->
      </div>
    </div>
    <div class="col-12 my-3">
      <div class="col-md-12">
        <table class="table table-hover" id="my-table">
          <thead>
            <tr>
              <th scope="col">Data</th>
              <th scope="col">Imóvel</th>
              <th scope="col" class="desktop">Contrato</th>
              <th scope="col">Corretor</th>
              <th scope="col">Visitante</th>
              <th scope="col" class="desktop">Observações</th>
              <th scope="col" class="desktop">Imobiliária Parceira</th>
              <!-- <th scope="col">Convertido</th>
              <th scope="col">Excluir</th> -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="visita in mudatabela" :key="visita.idvisita">
              <td>{{ visita.dia_visita }}</td>
              <td v-if="visita.codigo_imovel == '00000'">Prospecção  {{ visita.convertido ? '✅' : '' }}</td>
              <td v-else>{{ visita.codigo_imovel }}  {{ visita.convertido ? '✅' : '' }}</td>
              <td class="desktop">{{ visita.contrato }}</td>
              <td :style="'font-weight: bolder;color:'+(visita.cor ? visita.cor:'')">{{ visita.nomecorretor }}</td>
              <td>{{ visita.nome_cliente }}</td>
              <td class="desktop">{{ visita.observacoes }}</td>
              <td class="desktop">{{ visita.imobiliaria_parceria }}</td>
              <!-- <td>
                <Toggle
                  :id="'visitacontrato_' + visita.idvisita"
                  v-model="visita.convertido"
                  v-bind="form.contrato"
                  class="toggle-blue"
                />
              </td>
              <td>
                <button class="btn btn-danger" @click="excluir(visita.idvisita)">x</button>
              </td> -->
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
  
  <script lang="ts">
import {
  Chart as ChartJS,
  ArcElement,
  Tooltip,
  Legend,
  Title,
  BarElement,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
} from "chart.js";
import { Bar } from "vue-chartjs";
ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  ArcElement,
  Tooltip,
  Legend,
  PointElement,
  LineElement
);
import axios from "axios";

import Toggle from "@vueform/toggle";

export default {
  data() {
    return {
      visitas: [],
      corretores: [],
      corretoresdata: [],
      filtrarconvertidos: false,
      chartData: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", 'Out', 'Nov', 'Dez'],
        datasets: [
          {
            label: "Corretor A",
            backgroundColor: "#FF5733",
            data: [10, 15, 20, 12, 18, 25, 33, 22, 18],
          },
          {
            label: "Corretor B",
            backgroundColor: "#33FF57",
            data: [15, 10, 22, 14, 20, 28, 22, 12, 11],
          },
          {
            label: "Corretor C",
            backgroundColor: "#5733FF",
            data: [8, 12, 18, 10, 16, 22, 11, 22, 19],
          },
        ],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          x: {
            stacked: false,
          },
          y: {
            stacked: false,
          },
        },
      },
      form: {
        cliente: "",
        codigo: "",
        datavisita: "", // moment(Date()).format('DD/MM/YYYY'),
        marcado: true,
        semcodigo: false,
        contrato: {
          value: true,
          trueValue: 1,
          falseValue: 0,
          onLabel: "SIM",
          offLabel: "NÃO",
        },
        imobiliaria: "",
        obs: "",
        checked: true,
      },
    };
  },
  props: {
    propidsistema: Number,
    estagio: Number,
    tempo: String,
    anovindo: String,
  },
  components: {
    Bar,
    Toggle,
  },
  computed: {
    mudagrafico: function () {
      var corrs = [];
      var corretorfiltrado_s = [];
      var intervalotempo = [];
      var eixox = [
        "Jan",
        "Fev",
        "Mar",
        "Abr",
        "Mai",
        "Jun",
        "Jul",
        "Ago",
        "Set",
        "Out",
        "Nov",
        "Dez"
      ];
      // console.log(this.propidsistema);
      corretorfiltrado_s = this.corretores;
      if (this.propidsistema != 0) {
        corretorfiltrado_s = this.corretores.filter(
          (d) => d.idsistema == this.propidsistema
        );
      }
      // Filtra as visitas no gráfico
      intervalotempo = this.visitas.filter((v) => v.ano == this.anovindo);
      if (this.estagio == 1 || this.estagio == 0) {
        intervalotempo = intervalotempo.filter((d) => d.convertido == this.estagio);
      }
      if (this.estagio == 3) {
        intervalotempo = intervalotempo.filter((d) => d.codigo_imovel == '00000');
      }
      // Filtra as visitas no gráfico
      var cor_graphic = "blue";
      if (this.tempo !== "Atual") {
        intervalotempo = intervalotempo.filter((d) => d.mes == this.tempo);
        eixox = [this.tempo];
        for (let mesgrafico of eixox) {
          for (let corretor of corretorfiltrado_s) {
            if (corretor.ativo == 1) {
              var visitas_por_mes = [];
              var contagem = 0;
              for (let visita of intervalotempo) {
                if (
                  visita.mes == mesgrafico &&
                  visita.id_corretor == corretor.idsistema
                ) {
                  contagem++;
                  if (visita.cor != "") {
                    cor_graphic = visita.cor;
                  }
                }
              }
              visitas_por_mes.push(contagem);
              if (visitas_por_mes.reduce((acc, valor) => acc + valor, 0) > 0) {
                corrs.push({
                  label: corretor.nome,
                  backgroundColor: cor_graphic,
                  data: visitas_por_mes,
                });
              }
            }
          }
        }
      } else {
        for (let corretor of corretorfiltrado_s) {
          if (corretor.ativo == 1) {
            var visitas_por_mes = [];
            var cor_graphic = "blue";
            for (let mes of this.chartData.labels) {
              var contagem = 0;
              for (let visita of intervalotempo) {
                if (
                  visita.mes == mes &&
                  visita.id_corretor == corretor.idsistema
                ) {
                  contagem++;
                  if (visita.cor != "") {
                    cor_graphic = visita.cor;
                  }
                }
              }
              visitas_por_mes.push(contagem);
            }
            // console.log(visitas_por_mes.reduce((acc, valor) => acc + valor, 0));
            if (visitas_por_mes.reduce((acc, valor) => acc + valor, 0) > 0) {
              corrs.push({
                label: corretor.nome,
                backgroundColor: cor_graphic,
                data: visitas_por_mes,
              });
            }
          }
        }
      }
      

      return {
        labels: eixox,
        datasets: corrs,
      };
    },
    mudatabela: function () {
      var tabeladevisitas = this.visitas.filter((a) => a.ano == this.anovindo);
      if (this.propidsistema != 0) {
        tabeladevisitas = tabeladevisitas.filter(
          (d) => d.id_corretor == this.propidsistema
        );
      }
      if (this.tempo != "Atual") {
        tabeladevisitas = tabeladevisitas.filter((d) => d.mes == this.tempo);
      }
      if (this.estagio == 1 || this.estagio == 0) {
        tabeladevisitas = tabeladevisitas.filter((d) => d.convertido == this.estagio);
      }
      if (this.estagio == 3) {
        tabeladevisitas = tabeladevisitas.filter((d) => d.codigo_imovel == '00000');
      }
      return tabeladevisitas;
    },
  },
  updated() {
    console.log(this.anovindo)
  },
  created() {
    //   this.renderChart(this.chartData, this.chartOptions);
    // this.visitas
    axios
      .get("https://www.cafeimobiliaria.com.br/sistema/api/visita")
      .then((res) => {
        // console.log(res.data)
        this.visitas = res.data.filter(
          (d) =>
            d.id_corretor !== "" &&
            d.id_corretor !== null &&
            (d.data_visita.indexOf('2023') !== -1 || d.data_visita.indexOf('2024') !== -1)
        );
      });
    axios
      .get("https://www.cafeimobiliaria.com.br/dadoscorretor/api/corretor")
      .then((response) => {
        this.corretores = response.data;
        // console.log(this.corretores)
      });
  },
};
</script>
  <style src="@vueform/toggle/themes/default.css"></style>
<style>
.toggle-red {
  --toggle-bg-on: red;
  --toggle-border-on: red;
}

.toggle-blue {
  --toggle-width: 4.5rem;
  --toggle-height: 1.8rem;
  --toggle-border: 0.125rem;
  --toggle-border-radius: 0.025rem;
  --toggle-font-size: 0.75rem;
  --toggle-duration: 150ms;
  --toggle-bg-on: #009261;
  --toggle-bg-off: darkred;
  --toggle-bg-on-disabled: #d1d5db;
  --toggle-bg-off-disabled: #e5e7eb;
  --toggle-border-on: #009261;
  --toggle-border-off: darkred;
  --toggle-border-on-disabled: #d1d5db;
  --toggle-border-off-disabled: #e5e7eb;
  --toggle-ring-width: 3px;
  --toggle-ring-color: #10b98130;
  --toggle-text-on: #ffffff;
  --toggle-text-off: #ffffff;
  --toggle-text-on-disabled: #9ca3af;
  --toggle-text-off-disabled: #9ca3af;
  --toggle-handle-enabled: #ffffff;
  --toggle-handle-disabled: #f3f4f6;
  /* --toggle-width: 80px; */
  float: left;
  font-size: 18px !important;
  font-weight: bold;
}
.toggle {
  border-radius: 10px !important;
}
.toggle-handle {
  border-radius: 8px !important;
}
</style>