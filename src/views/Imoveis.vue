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
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
            </div>
            <sub>Em construção</sub>
            <hr>
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">Imóvel</th>
                    <th scope="col">Url - Campanha</th>
                    <th scope="col">Acessos/Mês</th>
                    <th scope="col">Visitas feitas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">PIN - 1235</th>
                    <td>https://cafeimobiliaria.com.br/campanha</td>
                    <td>243</td>
                    <td>3</td>
                    </tr>
                    <tr>
                    <th scope="row">PIN - 8734</th>
                    <td>https://cafeimobiliaria.com.br</td>
                    <td>454</td>
                    <td>7</td>
                    </tr>
                    <!-- <tr>
                    <th scope="row">3</th>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                    </tr> -->
                </tbody>
            </table>
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
      name: 'Imoveis',
      data() {
        return {
          corretor: [],
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
      created() {
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
      }
    }
  </script>