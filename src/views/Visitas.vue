<template>
    <div class="container text-left">
      <div class="row align-items-start">
        <div class="col-md-12 banner" style="position: relative;">
          <!-- <img src="src/assets/banner/banner-1.png" /> 
            
            Disposição do form (audio):
            Data de visita
            Código
            tirar o Contrato
            Nome do Visitante
            Observações
            Imobiliária parceira
          
          -->
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
            <h3>Registro de Visitas</h3>
            <!-- <p>Message is: {{ form.cliente }}</p> -->
            <!-- <input v-model="form.cliente" placeholder="edit me" /> -->
            <div class="container-fluid">
              <div class="col-md-6 col-sm-12">
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitadata">Data da Visita:</label>
                  </div>
                  <div class="col-sm-9">
                    <input v-mask="'##/##/####'" type="text" id="visitadata" class="form-control" v-model="form.datavisita" placeholder="__/__/_____"/>
                  </div>
                </div>
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitacodimovel">Código do Imóvel:</label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" id="visitacodimovel" class="form-control" v-model="form.codigo" placeholder="Código do Imóvel nos registros"/>
                  </div>
                </div>
                <!-- <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitacontrato">Contrato:</label>
                  </div>
                  <div class="col-sm-3">
                    <Toggle
                      id="visitacontrato"
                      v-model="form.contrato.value"
                      v-bind="form.contrato"
                      class="toggle-blue"
                    />
                  </div>
                </div> -->
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitacliente">Visitante:</label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" id="visitacliente" class="form-control" v-model="form.cliente" placeholder="Nome do cliente/visitante"/>
                  </div>
                </div>
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitacliente">imobiliaria Parceira:</label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" id="visitacliente" class="form-control" v-model="form.imobiliaria" placeholder="Se houver"/>
                  </div>
                </div>
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitacliente">Observações:</label>
                  </div>
                  <div class="col-sm-9">
                    <textarea type="text" id="visitacliente" class="form-control" v-model="form.obs"/>
                  </div>
                </div>
                <div class="row my-1 campo-formulario">
                  <button class="btn btn-successNo" @click="cadastrar">Registrar</button>
                </div>
              </div>
              <!-- Recebida as visitas, agora faremos a Tabela de Listagem -->
              <div class="col-md-12">
                <br />
                <br />
                <br />
              </div>
              <div class="col-md-12">
                <table class="table table-hover" id="my-table">
                  <thead>
                    <tr>
                      <th scope="col">Data</th>
                      <th scope="col">Imóvel</th>
                      <th scope="col">Visitante</th>
                      <th scope="col">Observações</th>
                      <th scope="col">Imobiliária Parceira</th>
                      <th scope="col">Convertido</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="visita in visitas">
                      <td>{{ visita.dia_visita }}</td>
                      <td>{{ visita.codigo_imovel }}</td>
                      <td>{{ visita.nome_cliente }}</td>
                      <td>{{ visita.observacoes }}</td>
                      <td>{{ visita.imobiliaria_parceira }}</td>
                      <td>
                        <Toggle
                          id="visitacontrato"
                          v-model="visita.convertido"
                          v-bind="form.contrato"
                          class="toggle-blue"
                        />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
    </div>
  </template>
  <script lang="ts">
  import Progress from './Progress.vue';
  import axios from "axios";
  import "@fontsource/exo-2";

  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
  } from 'chart.js';
  import { Bar } from 'vue-chartjs';

  ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

  import Toggle from '@vueform/toggle';

  export default {
      name: 'Imoveis',
      data() {
        return {
          corretor: [],
          posicao: 0,
          // urlmarca: "https://cafeimobiliaria.com.br/dadoscorretor",
          // urlmarca: "https://www.cafeimobiliaria.com.br/dadoscorretor/api/imovel",
          urlmarca: "http://localhost:8080/api/imovel",
          urlvisitas: "https://www.cafeimobiliaria.com.br/sistema/api/visita",
          // urlmarca: "",
          imoveis: [],
          todosimoveis: [],
          pagina: 1,
          totalpage: 1,
          por_pagina: 25,
          paginas: [],
          corretor_id: 12,
          graflabels: [],
          grafvalues: [],
          corretor: "",
          visitas: [],
          options: {
              responsive: true,
              maintainAspectRatio: true,
              legend: {
                  display: false
              }
          },
          form: {
            cliente: "Jonatas A. Silva",
            codigo: "12345",
            datavisita: "12/05/2023",
            marcado: true,
            contrato: {
              value: true,
              trueValue: 'on',
              falseValue: 'off',
              onLabel: 'SIM',
              offLabel: 'NÃO',
            },
            imobiliaria: "Café",
            obs: "Registro de visita de teste"

          }
      }
    },
    components: {
        Progress,
        Bar,
        Toggle
    },
    methods: {
      cadastrar () {
        console.log("bora chamar a API");
        axios.post("https://www.cafeimobiliaria.com/sistema/api/visita/create", {
          usuario_id: 1,
          data_visita: this.form.datavisita,
          observacoes: this.form.obs,
          codigo_imovel: this.form.codigo,
          nome_cliente: this.form.cliente,
          id_corretor: this.corretor
        })
      }
    },
    created() {
      if (localStorage.getItem('authUser')) {
        var getnome = JSON.parse(localStorage.getItem('authUser'));
        this.corretor = getnome.idsistema;
        // console.log(getnome);
        axios.get(this.urlvisitas).then((res) => {
          // console.log(res.data)
          this.visitas = res.data.filter(
            d => d.id_corretor == this.corretor &&
            d.id_corretor !== "" &&
            d.id_corretor !== null &&
            d.data_visita.indexOf("2023") !== -1
          );
          // console.log(this.visitas)
        })
      }
    },
  }
</script>
<style src="@vueform/toggle/themes/default.css"></style>
<style>
  /* @media (min-width: 1024px) {
    .universidade {
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
  } */
  :root {
    --toggle-bg-on: #10b98157 !important;
    --toggle-bg-off: #a2ff00 !important;
  }
  label {
    display: inline-block;
    margin-bottom: 0.5rem;
  }
  .for-label {
    text-align: left;
    float: left;
    font-weight: bolder;
  }
  .campo-formulario {
    margin: 10px 1px !important;
    border: 1px solid lightgray;
    padding: 2% 5%;
    border-radius: 10px;;
  }
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
  