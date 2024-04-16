<template>
  <div class="container text-left">
    <div class="row align-items-start">
      <div class="col-md-12 banner" style="position: relative;">
        <!-- <img src="src/assets/banner/banner-1.png" /> -->
        <div class="vertical-center" style="width: 305px !important;">
          <h5 class="titulo-dash" style="">
            Veja como estipular suas<br>
            metas de maneiras alcançáveis.
          </h5>
          <a class="btn btn-transparente float-right" href="#">ver mais</a>
        </div>
      </div>
      <div class="col-md-12 dash-corretor">
        <h4>Seu <br>Dashboard |
        <span>
          <select id="" class="form-de-topo" v-model="searchTime" @change="filtrar()" style="width: 187px;">
            <option value="Atual">Média geral</option>
            <option value="1">Janeiro</option>
            <option value="2">Fevereiro</option>
            <option value="3">Março</option>
            <option value="4">Abril</option>
            <option value="5">Maio</option>
            <option value="6">Junho</option>
            <option value="7">Julho</option>
            <option value="8">Agosto</option>
            <option value="9">Setembro</option>
            <option value="10">Outubro</option>
            <option value="11">Novembro</option>
            <option value="12">Dezembro</option>
            <option value="trimestre_1">1º Trimestre</option>
            <option value="trimestre_2">2º Trimestre</option>
            <option value="trimestre_3">3º Trimestre</option>
            <option value="trimestre_4">4º Trimestre</option>
          </select>
        </span>
        </h4>
        <h6 class="text-center mb-4 fw-bolder">Atualizado até Dezembro-2023</h6>
        <div class="row align-items-start">
          <div class="col-12 col-md-8 col-lg-4 item-progresso" style="">
            <div class="row align-items-start subcard-corretor"
              style="height: 120px; padding: 5px;margin: 0 15px; position: relative;">
              <div class="col-5 col-md-5" style="border-right: 1px solid #e3e3e3; height: 110px; position: relative;">
                <h3 class="center-center" style="text-align: center;">{{ posicao }}</h3>
              </div>
              <div class="col-6 col-md-7" style="height: 120px !important; position: relative;">
                <label class="vertical-center" style="margin-left: 30px !important;">
                  <font-awesome-icon icon="bell" class="" style="font-size: 20px;" />
                  <br>
                  Ranking Geral<br>de vendas
                </label>
              </div>
            </div>
          </div>
          <div class="col-6 col-lg-2 col-md-4 col-sm-6 item-progresso" v-for="macro in macros" :key="macro.id">
            <Progress v-bind:legenda="macro.campo" v-bind:valor="macro.valor" v-bind:param="macro.param"
              v-bind:prefixo="macro.prefx"></Progress>
          </div>
          <div class="col-6 col-md-4 col-lg-2 item-progresso"></div>
          <div class="col-6 col-md-4 col-lg-2 item-progresso" style="margin-top: 60px; text-align: left;">
            <font-awesome-icon icon="circle-down" class="fa-sharp fa-solid" style="font-size: 20px;" />
            <br />
            <span>
              Baixar relatório<br>
              completo
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-12 dash-corretor my-4" style="background-color: gray;">
        <label for="codigo-atualizar" class="w-100 fw-bolder fs-5 text-white mb-4 my-3">Para atualizar um Imóvel<br><br>digite o código</label>
        <input id="codigo-atualizar" v-model="codigo" type="text" class="form-de-topo" style="height: 40px;">
        <br>
        <a v-show="codigo != ''" :href="'https://www.cafeimobiliaria.com.br/atualizar.php?codigo=' + codigo" class="btn btn-primary text-white" target="_blank">Atualizar Imóvel {{ codigo }}</a>
      </div>
      <div class="col-md-12 elimina-margens-internas">
        <div class="row">
          <!-- <div class="col-md-2"></div> -->
          <div class="col-md-6">
            <div class="dash-corretor-topico">
              <img src="@/assets/banner/Tii.png" />
              <!-- Bora, hora do show porra -->
              <div class="row">
                <div class="col-12 col-lg-5 col-md-12 col-sm-12">
                  <div style="width: 100% !important; height: 200px !important;"></div>
                </div>
                <div class="col-12 col-lg-7 col-md-12 col-sm-12">
                  <br>
                  <strong class="dash-corretor-topico-titulo" style="float: left">Incentivo Semanal</strong>
                  <br>
                  <p align="left" class="dash-corretor-topico-conteudo">
                    <br>
                    <br>
                    <br>
                    Em  breve!
                    <!-- Ganhe<br> -->
                    <!-- R$ <strong>150,00</strong> ao cadastrar<br><strong>5 imóveis</strong> acima de R$ 500 mil -->
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-1"></div> -->
          <div class="col-md-6">
            <div class="dash-corretor-topico alinhando-direita">
              <div class="row">
                <div class="col-md-6">
                  <h4 class="dash-corretor-topico-titulo" style="text-align: center">Metas<br>mensais</h4>
                  <br>
                  <p class="dash-corretor-topico-conteudo">Meta Vendas: <strong>R$ 20.000 VGC</strong>
                    <br>Super Meta: <strong>R$ 29.000 VGC</strong>
                  </p>
                </div>
                <div class="col-md-5">
                  <ul class="lista-metas dash-corretor-topico-conteudo"
                    style="text-align: left; font-size: 12px;line-height: 30px;">
                    <li><br></li>
                    <li>Agenciamentos: <strong>6 (2 vídeos)</strong></li>
                    <li>Placas: <strong>6</strong></li>
                    <li>Gestão de Imóveis: <strong>20</strong></li>
                    <li>Recuperação de Leads: <strong>5/dia</strong></li>
                    <li>Prospecções: <strong>5/semana</strong></li>
                  </ul>
                </div>
                <div class="col-12 col-md-1 vertical-center-right" style="height: 180px;">
                  <div class="line-progress-div">
                    <span class="dot"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <Bar :data="data" :options="options" /> -->
</template>

<script lang="ts">
import Progress from './Progress.vue';
import axios from "axios";
import "@fontsource/exo-2";
export default {
  name: 'home',
  data() {
    return {
      codigo: '',
      corretor: [],
      dadoscorretor: [],
      searchTime: 'Atual',
      posicao: 0,
      macros: [{
        campo: "Leads Recebidos",
        valor: 0,
        param: "",
        prefx: ""
      },
      {
        campo: "Percentual de Conversão",
        valor: 0,
        param: "%",
        prefx: ""
      },
      {
        campo: "Quant. Vendas VGC",
        valor: 0,
        param: "",
        prefx: ""
      },
      {
        campo: "Quant. Vendas VGV",
        valor: 0,
        param: "",
        prefx: ""
      },
      {
        campo: "Quant. de Visitas",
        valor: 0,
        param: "",
        prefx: ""
      },
      {
        campo: "Quant. Imóveis Agenciados",
        valor: 0,
        param: "",
        prefx: ""
      },
      {
        campo: "Ticket Médio de Venda",
        valor: 0,
        param: "",
        prefx: "R$"
      },
      {
        campo: "Custo do Lead",
        valor: 0,
        param: "",
        prefx: "R$"
      },]
    }
  },
  components: {
    Progress
  },
  methods: {
    filtrar () {
      // console.log(this.searchTime)
      if (this.corretor.macros.length >= 1) {
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

        var trimestre1 = [1, 2, 3];
        var trimestre2 = [4, 5, 6];
        var trimestre3 = [7, 8, 9];
        var trimestre4 = [10, 11, 12];

        for(let mc of this.corretor.macros) {
          // this.corretorlabels.push(moment(String(mc.data)).format('DD/MM/YYYY'));
          // for(let mc2 of this.corretor.macros) {
            // leadsrecebidos.push(mc2.leads_recebidos);
            // percentual_conversao.push(mc2.percentual_conversao);
            // quant_vendas_vgc.push(mc2.quant_vendas_vgc);
            // quant_vendas_vgv.push(mc2.quant_vendas_vgv);
            // quant_visitas.push(mc2.quant_visitas);
            // quant_imoveis_agenciados.push(mc2.quant_imoveis_agenciados);
          // }
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
          } 
          else if(varindice == "trimestre_1") {
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
            }
          }
          else if(varindice == "trimestre_2") {
            if (trimestre2.includes(mc.mes_referencia)) {
              leadsrecebidos += mc.leads_recebidos;
              percentual_conversao += Number(mc.percentual_conversao);
              console.log(mc.percentual_conversao);
              quant_vendas_vgc += mc.quant_vendas_vgc;
              quant_vendas_vgv += mc.quant_vendas_vgv;
              quant_visitas += mc.quant_visitas;
              quant_imoveis_agenciados += mc.quant_imoveis_agenciados;
              ticket_medio_venda += Number(mc.ticket_medio_venda);
              custo_lead += Number(mc.custo_lead);
              i++;
            }
          }
          else if(varindice == "trimestre_3") {
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
            }
          }
          else if(varindice == "trimestre_4") {
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
            }
          } 
          else {
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
              i++;
            }
          }
        }

        // console.log("" + Math.round(leadsrecebidos/i))

        // ------------------------------------------------------------
        // Última posição registrada:
        // Divide por "i" para valores médios
        var ultimo_indice = this.corretor.macros.length-1;
        this.posicao = this.corretor.macros[ultimo_indice].pos_ranking_geral_vendas;
        this.macros = [
        {
            campo: "Leads Recebidos",
            valor: (i > 0 ? Math.round(leadsrecebidos) : leadsrecebidos),
            param: "",
            prefx: ""
          },
          {
            campo: "Percentual de Conversão",
            valor: (leadsrecebidos > 0 ? Math.round((custo_lead/leadsrecebidos)/0.01) : 0),
            param: "%",
            prefx: ""
          },
          {
            campo: "Quant. de Visitas",
            valor: (i > 0 ? Math.round(quant_visitas) : quant_visitas),
            param: "",
            prefx: ""
          },
          {
            campo: "Quant. Imóveis Agenciados",
            valor: (i > 0 ? Math.round(quant_imoveis_agenciados) : quant_imoveis_agenciados),
            param: "",
            prefx: ""
          },
          {
            campo: "Vendas VGC",
            valor: (i > 0 ? Math.round(quant_vendas_vgc).toLocaleString() : quant_vendas_vgc),
            param: "",
            prefx: "R$"
          },
          {
            campo: "Vendas VGV",
            valor: (i > 0 ? Math.round(quant_vendas_vgv).toLocaleString() : quant_vendas_vgv),
            param: "",
            prefx: "R$"
          },
          {
            campo: "Ticket Médio de Venda",
            valor: (custo_lead > 0 ? Math.round(((quant_vendas_vgc + quant_vendas_vgv)/custo_lead)).toLocaleString() : 0),
            param: "",
            prefx: "R$"
          },
          {
            campo: "Vendas",
            valor: custo_lead,
            param: "",
            prefx: ""
          },
        ]
      }
    }
  },
  created() {
    /*
    axios.get("http://localhost:8080/api/corretor/view?id=1").then((res) => {
          console.log(res.data)
          this.corretor = res.data;
          console.log("Macros:");
          console.log(this.corretor.macros[0]);
          this.posicao = this.corretor.macros[0].pos_ranking_geral_vendas;
          this.macros = [
            {
              campo: "Leads Recebidos",
              valor: this.corretor.macros[0].leads_recebidos,
              param: "",
              prefx: ""
            },
            {
              campo: "Percentual de Conversão",
              valor: Math.round(this.corretor.macros[0].percentual_conversao),
              param: "%",
              prefx: ""
            },
            {
              campo: "Quant. Vendas VGC",
              valor: this.corretor.macros[0].quant_vendas_vgc,
              param: "",
              prefx: ""
            },
            {
              campo: "Quant. Vendas VGV",
              valor: this.corretor.macros[0].quant_vendas_vgv,
              param: "",
              prefx: ""
            },
            {
              campo: "Quant. de Visitas",
              valor: this.corretor.macros[0].quant_visitas,
              param: "",
              prefx: ""
            },
            {
              campo: "Quant. Imóveis Agenciados",
              valor: this.corretor.macros[0].quant_imoveis_agenciados,
              param: "",
              prefx: ""
            },
            {
              campo: "Ticket Médio de Venda",
              valor: Math.round(this.corretor.macros[0].ticket_medio_venda).toLocaleString(),
              param: "",
              prefx: "R$"
            },
            {
              campo: "Custo do Lead",
              valor: Math.round(this.corretor.macros[0].custo_lead),
              param: "",
              prefx: "R$"
            },
          ]
          console.log("pros circles");
          console.log(this.macros)
    })
    .catch((error) => {
            console.log(error);
    });
    */
    if (localStorage.getItem('authUser')) {
      this.dadoscorretor = localStorage.getItem('authUser');
      this.corretor = JSON.parse(this.dadoscorretor);
      this.filtrar();
    }
  }
}
</script>
<style>
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
  background-image: url('/src/assets/banner/banner-1.png');
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
    background-image: url('/src/assets/banner/banner-1.png');
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
</style>