<template>
  <div class="container text-left">
    <div class="row align-items-start">
      <div class="col-md-12 banner" style="position: relative">
        <!-- <img src="src/assets/banner/banner-1.png" /> -->
        <div class="vertical-center" style="width: 305px !important">
          <h5 class="titulo-dash" style="">
            Veja como estipular suas<br />
            metas de maneiras alcançáveis.
          </h5>
          <a class="btn btn-transparente float-right" href="#">ver mais</a>
        </div>
      </div>
      <div class="col-md-12 dash-corretor">
        <h4 class="">
          <span class="col">Relatórios de Visitas e<br>Prospecções |</span>
          <span>
            <select
              id="lista-de-corretores"
              class="form-de-topo mx-2"
              v-model="searchCorretor"
              @change="filtrarCorretor()"
              style="width: 210px"
            >
              <option value="0">Todos os corretores</option>
              <option
                v-for="corretor in corretores"
                :key="corretor.id"
                :value="corretor.id"
              >
                {{ corretor.nome }}
              </option>
            </select>
          </span>
          <span>
            <select
              id=""
              class="form-de-topo mx-2"
              v-model="searchTime"
              @change="filtrar()"
              style="width: 187px"
            >
              <option value="Atual">Ano 2023</option>
              <option value="Jan">Janeiro</option>
              <option value="Fev">Fevereiro</option>
              <option value="Mar">Março</option>
              <option value="Abr">Abril</option>
              <option value="Mai">Maio</option>
              <option value="Jun">Junho</option>
              <option value="Jul">Julho</option>
              <option value="Ago">Agosto</option>
              <option value="Set">Setembro</option>
              <option value="Out">Outubro</option>
              <option value="Nov">Novembro</option>
              <option value="Dez">Dezembro</option>
              <!-- <option value="trimestre_1">1º Trimestre</option>
              <option value="trimestre_2">2º Trimestre</option>
              <option value="trimestre_3">3º Trimestre</option>
              <option value="trimestre_4">4º Trimestre</option> -->
            </select>
            <!-- <button @click="ordemCorretores(54)">VerOrdem</button> -->
          </span>
          <span>
            <label for="estagio-situacao" class="mx-2">Estágio:</label>
            <select
              id="estagio-situacao"
              class="form-de-topo"
              v-model="filtrarconvertidos"
              style="width: 150px"
            >
              <option value="2">Todos</option>
              <option value="1">Convertidos</option>
              <option value="0">Não convertidos</option>
              <option value="3">Prospecção</option>
            </select>
          </span>
        </h4>
        <span>
        </span>
      </div>
      <div class="col-md-12 dash-corretor">
        <ChartVisitas
          v-bind:corretores="corretores"
          v-bind:propidsistema="propcorretor"
          v-bind:tempo="searchTime"
          v-bind:estagio="filtrarconvertidos"
        >
        </ChartVisitas>
      </div>
    </div>
  </div>
  <!-- <Bar :data="data" :options="options" /> -->
</template>

<script lang="ts">
import Progress from "./Progress.vue";
import ChartVisitas from "./ChartVisitas.vue";
import axios from "axios";
import "@fontsource/exo-2";
import Toggle from '@vueform/toggle';
export default {
  name: "admvisitas",
  data() {
    return {
      filtrarconvertidos: 2,
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
            onLabel: 'Convertidos',
            offLabel: 'Não convertidos',
          },
          imobiliaria: "",
          obs: "",
          checked: true
      },
      meses: [
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
        "Dez",
      ],
      corretor: [],
      dadoscorretor: [],
      searchTime: "Atual",
      searchCorretor: 0,
      propcorretor: 0,
      posicao: 0,
      apibase: "https://www.cafeimobiliaria.com.br/dadoscorretor/api/corretor",
      urlvisitas: "https://www.cafeimobiliaria.com.br/sistema/api/visita",
      macros: [
        {
          campo: "Leads Recebidos",
          valor: 0,
          param: "",
          prefx: "",
        },
        {
          campo: "Percentual de Conversão",
          valor: 0,
          param: "%",
          prefx: "",
        },
        {
          campo: "Quant. Vendas VGC",
          valor: 0,
          param: "",
          prefx: "",
        },
        {
          campo: "Quant. Vendas VGV",
          valor: 0,
          param: "",
          prefx: "",
        },
        {
          campo: "Quant. de Visitas",
          valor: 0,
          param: "",
          prefx: "",
        },
        {
          campo: "Quant. Imóveis Agenciados",
          valor: 0,
          param: "",
          prefx: "",
        },
        {
          campo: "Ticket Médio de Venda",
          valor: 0,
          param: "",
          prefx: "R$",
        },
        {
          campo: "Custo do Lead",
          valor: 0,
          param: "",
          prefx: "R$",
        },
      ],
      corretores: [],
      corretormacros: [],
      corretorlabels: [],
      listacorretoresvgc: [],
      sociosids: [10, 42, 43, 1]
    };
  },
  components: {
    Progress,
    ChartVisitas,
    Toggle
  },
  methods: {
    ordemCorretores(idcorretor) {
      var listadecorretores = [];
      for (let corretor of this.corretores) {
        var somatoria = 0;
        if (!this.sociosids.includes(corretor.id)) {
          for (let macro of corretor.macros) {
            somatoria = somatoria + macro.quant_vendas_vgc;
          }
          listadecorretores.push({
            id: corretor.id,
            vgc: somatoria,
          });
        }
      }
      listadecorretores.sort(function (a, b) {
        return b.vgc - a.vgc;
      });
      // console.log("Index: ");
      // console.log(listadecorretores.map((idd) => idd.id).indexOf(65));
      // console.log(listadecorretores);
      var corretorpos = 0;
      corretorpos =
        listadecorretores.map((idd) => idd.id).indexOf(idcorretor) + 1;
      // console.log(corretorpos);
      return corretorpos;
    },
    filtrarCorretor() {
      // console.log("corretor: " + this.searchCorretor);
      var spropcorretor = 0;
      for (let corretor of this.corretores) {
        if (corretor.id == this.searchCorretor) {
          this.corretor = corretor;
          // break;
          spropcorretor = corretor.idsistema
        }
      }
      this.filtrar();
      this.propcorretor = spropcorretor;
    },
    filtrar() {
      // ##############################################################################
      // NOTA: O campo custo_lead refere-se agora a Quant. Vendas
      // ##############################################################################

      // console.log(this.searchTime)
      // if (this.corretor.macros.length >= 1) {
      var varindice = this.searchTime;
      // temos que ajustar pra somar os valores inseridos NO MÊS
      // Usar Foreach
      var leadsrecebidos = 0;
      var percentual_conversao = 0;
      var quant_vendas_vgc = 0;
      var quant_vendas_vgv = 0;
      var quant_visitas = 0;
      var quant_imoveis_agenciados = 0;
      var ticket_medio_venda = 0;
      var custo_lead = 0;

      var i = 0; // Contador
      var j = 0; // Contador de Mês-Entradas de registro

      var trimestre1 = [1, 2, 3];
      var trimestre2 = [4, 5, 6];
      var trimestre3 = [7, 8, 9];
      var trimestre4 = [10, 11, 12];

      for (let mc of this.corretor.macros) {
        // this.corretorlabels.push(moment(String(mc.data)).format('DD/MM/YYYY'));
        // for(let mc2 of this.corretor.macros) {
        // leadsrecebidos.push(mc2.leads_recebidos);
        // percentual_conversao.push(mc2.percentual_conversao);
        // quant_vendas_vgc.push(mc2.quant_vendas_vgc);
        // quant_vendas_vgv.push(mc2.quant_vendas_vgv);
        // quant_visitas.push(mc2.quant_visitas);
        // quant_imoveis_agenciados.push(mc2.quant_imoveis_agenciados);
        // }
        // console.log(mc.percentual_conversao);
        if (varindice == "Atual") {
          // console.log(mc);
          leadsrecebidos += mc.leads_recebidos;
          percentual_conversao += Number(mc.percentual_conversao);
          quant_vendas_vgc += mc.quant_vendas_vgc;
          quant_vendas_vgv += mc.quant_vendas_vgv;
          quant_visitas += mc.quant_visitas;
          quant_imoveis_agenciados += mc.quant_imoveis_agenciados;
          ticket_medio_venda += Number(mc.ticket_medio_venda);
          custo_lead += Number(mc.custo_lead);
          i++;
          if (mc.percentual_conversao > 1) {
            j++;
          }
        } else if (varindice == "trimestre_1") {
          if (trimestre1.includes(mc.mes_referencia)) {
            leadsrecebidos += mc.leads_recebidos;
            percentual_conversao += Number(mc.percentual_conversao);
            quant_vendas_vgc += mc.quant_vendas_vgc;
            quant_vendas_vgv += mc.quant_vendas_vgv;
            quant_visitas += mc.quant_visitas;
            quant_imoveis_agenciados += mc.quant_imoveis_agenciados;
            ticket_medio_venda += Number(mc.ticket_medio_venda);
            custo_lead += Number(mc.custo_lead);
            i++;
            if (mc.percentual_conversao > 1) {
              j++;
            }
          }
        } else if (varindice == "trimestre_2") {
          if (trimestre2.includes(mc.mes_referencia)) {
            leadsrecebidos += mc.leads_recebidos;
            percentual_conversao += Number(mc.percentual_conversao);
            // console.log(mc.percentual_conversao);
            quant_vendas_vgc += mc.quant_vendas_vgc;
            quant_vendas_vgv += mc.quant_vendas_vgv;
            quant_visitas += mc.quant_visitas;
            quant_imoveis_agenciados += mc.quant_imoveis_agenciados;
            ticket_medio_venda += Number(mc.ticket_medio_venda);
            custo_lead += Number(mc.custo_lead);
            i++;
            if (mc.percentual_conversao > 1) {
              j++;
            }
          }
        } else if (varindice == "trimestre_3") {
          if (trimestre3.includes(mc.mes_referencia)) {
            leadsrecebidos += mc.leads_recebidos;
            percentual_conversao += Number(mc.percentual_conversao);
            quant_vendas_vgc += mc.quant_vendas_vgc;
            quant_vendas_vgv += mc.quant_vendas_vgv;
            quant_visitas += mc.quant_visitas;
            quant_imoveis_agenciados += mc.quant_imoveis_agenciados;
            ticket_medio_venda += Number(mc.ticket_medio_venda);
            custo_lead += Number(mc.custo_lead);
            i++;
            if (mc.percentual_conversao > 1) {
              j++;
            }
          }
        } else if (varindice == "trimestre_4") {
          if (trimestre4.includes(mc.mes_referencia)) {
            leadsrecebidos += mc.leads_recebidos;
            percentual_conversao += Number(mc.percentual_conversao);
            quant_vendas_vgc += mc.quant_vendas_vgc;
            quant_vendas_vgv += mc.quant_vendas_vgv;
            quant_visitas += mc.quant_visitas;
            quant_imoveis_agenciados += mc.quant_imoveis_agenciados;
            ticket_medio_venda += Number(mc.ticket_medio_venda);
            custo_lead += Number(mc.custo_lead);
            i++;
            if (mc.percentual_conversao > 1) {
              j++;
            }
          }
        } else {
          if (mc.mes_referencia == varindice) {
            // console.log("conjunto de etapa filtrado:");
            // console.log(mc);
            leadsrecebidos += mc.leads_recebidos;
            percentual_conversao += Number(mc.percentual_conversao);
            quant_vendas_vgc += mc.quant_vendas_vgc;
            quant_vendas_vgv += mc.quant_vendas_vgv;
            quant_visitas += mc.quant_visitas;
            quant_imoveis_agenciados += mc.quant_imoveis_agenciados;
            ticket_medio_venda += Number(mc.ticket_medio_venda);
            custo_lead += Number(mc.custo_lead);
            this.posicao = mc.pos_ranking_geral_vendas;
            i++;
            if (mc.percentual_conversao > 1) {
              j++;
            }
          }
        }
      }

      // console.log("" + Math.round(leadsrecebidos/i))

      // ------------------------------------------------------------
      // Última posição registrada:
      // Divide por "i" para valores médios
      // console.log("contagem: " + i);
      // console.log("contagem meses com registro: " + j);

      var ultimo_indice = this.corretor.macros.length - 1;
      if (this.searchTime == "Atual") {
        this.posicao = this.ordemCorretores(this.corretor.id);
      } 
      // else {
      //   if (this.corretor.macros.length >= 1) {
      //     this.posicao = this.corretor.macros[this.searchTime-1].pos_ranking_geral_vendas;
      //   }
      // }
      this.macros = [
        {
          campo: "Leads Recebidos",
          valor: i > 0 ? Math.round(leadsrecebidos) : leadsrecebidos,
          param: "",
          prefx: "",
        },
        {
          campo: "Percentual de Conversão",
          valor:
            leadsrecebidos > 0
              ? Math.round(custo_lead / (leadsrecebidos + quant_imoveis_agenciados) / 0.01)
              : 0,
          param: "%",
          prefx: "",
        },
        {
          campo: "Quant. de Visitas",
          valor: i > 0 ? Math.round(quant_visitas) : quant_visitas,
          param: "",
          prefx: "",
        },
        {
          campo: "Quant. Imóveis Agenciados",
          valor:
            i > 0
              ? Math.round(quant_imoveis_agenciados)
              : quant_imoveis_agenciados,
          param: "",
          prefx: "",
        },
        {
          campo: "Vendas VGC",
          valor:
            i > 0
              ? Math.round(quant_vendas_vgc).toLocaleString()
              : quant_vendas_vgc,
          param: "",
          prefx: "R$",
        },
        {
          campo: "Vendas VGV",
          valor:
            i > 0
              ? Math.round(quant_vendas_vgv).toLocaleString()
              : quant_vendas_vgv,
          param: "",
          prefx: "R$",
        },
        {
          campo: "Ticket Médio de Venda",
          valor:
            custo_lead > 0
              ? Math.round(
                  (quant_vendas_vgc + quant_vendas_vgv) / custo_lead
                ).toLocaleString()
              : 0,
          param: "",
          prefx: "R$",
        },
        {
          campo: "Vendas",
          valor: custo_lead,
          param: "",
          prefx: "",
        },
      ];
    },
  },
  created() {
    if (localStorage.getItem("authUser")) {
      this.dadoscorretor = localStorage.getItem("authUser");
      this.corretor = JSON.parse(this.dadoscorretor);
      // this.searchCorretor = this.corretor.id;
      this.filtrar();
    }
    axios.get(this.apibase).then((response) => {
      this.corretores = response.data.filter((den) => den.ativo == 1);
    });
  },
};
</script>
<style scoped>
:root {
  --blue: #1e90ff;
  --white: #ffffff;
  --backshadown-img: drop-shadow(23.16px 17.453px 32.5px rgba(0, 0, 0, 0.16));
  --backshadown-imgpii: drop-shadow(3.517px 8.285px 23px rgba(0, 0, 0, 0.22));
  --backshadown: 23.16px 17.453px 32.5px rgba(0, 0, 0, 0.16);
  --backshadown-rank: 12.778px 9.629px 16px rgba(0, 0, 0, 0.16);
  --backshadown-subcard: 12.778px 9.629px 17.5px rgba(0, 0, 0, 0.11);
}

.form-de-topo {
  border: 1px solid ghostwhite;
  border-radius: 10px;
  box-shadow: var(--backshadown-rank);
  margin-bottom: 20px;
  padding: 5px 10px;
  color: #053a35;
  background-color: white;
}

/* var backshadown = drop-shadow(23.16px 17.453px 32.5px rgba(0,0,0,0.16)); */
.banner {
  width: 100%;
  padding: 0 !important;
  margin: 0 !important;
}

/* .banner img {
    width: 100%;
    -webkit-filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.2));
    filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.2));
    /* box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
  } */
.dash-corretor {
  background-color: white;
  border-radius: 20px;
  margin-top: 5%;
  box-shadow: var(--backshadown);
  padding: 2% 4% !important;
}

.dash-corretor h4 {
  font-size: 18px;
  line-height: 25px;
  color: #053a35;
  font-weight: 900;
  font-family: "Open Sans";
  text-align: left;
}

.subcard-corretor {
  border-radius: 20px;
  box-shadow: var(--backshadown-rank);
  font-size: 12px;
  line-height: 19px;
  color: #053a35;
  font-weight: 700;
  font-family: "Open Sans";
  text-align: left;
  width: 100%;
  margin-left: -5% !important;
  background-color: white;
}

.vertical-center {
  margin: 0 !important;
  position: absolute !important;
  top: 50% !important;
  left: 0% !important;
  -ms-transform: translateY(-50%) !important;
  transform: translateY(-50%) !important;
}

.vertical-align {
  margin: 0 !important;
  position: absolute !important;
  top: 50% !important;
  /* left: 0% !important; */
  -ms-transform: translateY(-50%) !important;
  transform: translateY(-50%) !important;
}

.vertical-center-right {
  margin: 0 !important;
  position: absolute !important;
  top: 50% !important;
  right: 0% !important;
  -ms-transform: translateY(-50%) !important;
  transform: translateY(-50%) !important;
}

.center-center {
  margin: 0 !important;
  position: absolute !important;
  top: 50% !important;
  left: 0 !important;
  right: 0 !important;
  -ms-transform: translateY(-50%) !important;
  transform: translateY(-50%) !important;
}

.dash-corretor-topico {
  background-color: white;
  border-radius: 20px;
  margin-top: 10%;
  box-shadow: var(--backshadown);
  padding: 2%;
  height: 220px;
  position: relative;
  /* float: right; */
}

.dash-corretor-topico-titulo {
  font-size: 20px;
  letter-spacing: 0px;
  /* line-height: 34px; */
  color: #053a35;
  font-weight: 700;
  font-family: "Exo 2";
  margin-top: 35px;
  /* margin-bottom: 20px; */
  width: 100%;
  text-align: left;
}

.dash-corretor-topico-conteudo {
  font-size: 13px;
  letter-spacing: 0px;
  line-height: 20px;
  color: #053a35;
  /* font-weight: 700; */
  /* font-family: "Exo 2"; */
}

.dash-corretor-topico img {
  position: absolute;
  left: -50px;
  top: -30px;
  height: 300px;
  -webkit-filter: var(--backshadown-imgpii);
  filter: var(--backshadown-imgpii);
}

.align-div-right {
  /* outline: auto; */
  float: right !important;
  padding-right: 0 !important;
}

.item-progresso {
  padding-left: 5%;
  padding-bottom: 5%;
}

.banner {
  height: 170px;
  border-radius: 30px;
  background-image: url("/src/assets/banner/banner-1.png");
  background-repeat: no-repeat;
  background-size: 100% 240px;
  box-shadow: var(--backshadown);
  width: 100% !important;
  background-color: gray;
}

.line-progress-div {
  height: 180px;
  border-left: 3px solid lightgray;
  float: right;
  margin-right: 15px;
}

.dot {
  height: 12px;
  width: 12px;
  background-color: gray;
  border-radius: 50%;
  display: inline-block;
  margin-left: -8px;
  margin-top: 20px;
  position: absolute;
}

.lista-metas {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.float-right {
  float: right;
}

.btn-transparente {
  padding: 1% 3%;
  border: 1px solid #2d460b;
  border-radius: 20px;
}

.elimina-margens-externas {
  margin: 0 !important;
}

.elimina-margens-internas {
  padding: 0 !important;
}

.titulo-dash {
  font-size: 20px;
  letter-spacing: -1px;
  line-height: 32px;
  color: #053a35;
  font-weight: 300;
  font-family: "Exo 2";
  text-align: left;
  padding-left: 15%;
}

.alinhando-direita {
  width: 95%;
  margin-left: 5%;
}

@media only screen and (max-width: 1200px) {
  .banner {
    height: 240px;
    border-radius: 30px;
    background-image: url("/src/assets/banner/banner-1.png");
    background-repeat: no-repeat;
    background-size: auto 240px;
    box-shadow: var(--backshadown);
    width: 100% !important;
    background-color: gray;
    background-position-x: 55%;
  }

  .dash-corretor-topico {
    background-color: white;
    border-radius: 20px;
    margin-top: 10%;
    box-shadow: var(--backshadown);
    padding: 2%;
    height: 420px;
    position: relative;
    width: 100%;
    padding: 15px;
    /* float: right; */
  }

  .dash-corretor-topico img {
    position: absolute;
    left: 0px;
    top: 0px;
    height: 250px;
    -webkit-filter: var(--backshadown-imgpii);
    filter: var(--backshadown-imgpii);
  }

  .dash-corretor-topico .col-md-5 {
    height: 200px;
  }

  .subcard-corretor {
    margin-left: -1% !important;
    background-color: white;
  }

  .alinhando-direita {
    width: 100%;
    margin-left: 0%;
  }
}
.toggle-red {
    --toggle-bg-on: red;
    --toggle-border-on: red;
  }

  .toggle-blue {
    --toggle-width: 8.5rem !important;
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
    --toggle-ring-color: #10B98130;
    --toggle-text-on: #ffffff;
    --toggle-text-off: #ffffff;
    --toggle-text-on-disabled: #9ca3af;
    --toggle-text-off-disabled: #9ca3af;
    --toggle-handle-enabled: #ffffff;
    --toggle-handle-disabled: #f3f4f6;
    /* --toggle-width: 80px; */
    float: left;
    font-size: 18px !important;
    font-weight: bold
    
  }
  .toggle {
    border-radius: 10px !important;
  }
  .toggle-handle {
    border-radius: 8px !important;
  }
</style>
