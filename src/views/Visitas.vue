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
            <h3>Registro de Visitas</h3>
            <!-- <p>Message is: {{ form.cliente }}</p> -->
            <!-- <input v-model="form.cliente" placeholder="edit me" /> -->
            <div class="container-fluid">
              <div class="row my-1">
                <div class="col-sm-3">
                  <label for="type-text">Nome do Cliente:</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" id="type-text" class="form-control" v-model="form.cliente" placeholder="Enter your name"/>
                </div>
              </div>
              <div class="row my-1">
                <div class="col-sm-3">
                  <label for="type-text">Código do Imóvel:</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" id="type-text" class="form-control" v-model="form.cliente" placeholder="Enter your name"/>
                </div>
              </div>
              <div class="row my-1">
                <div class="col-sm-3">
                  <label for="type-text-data">Código do Imóvel:</label>
                </div>
                <div class="col-sm-9">
                  <input v-mask="'##/##/####'" type="text" id="type-text-data" class="form-control" v-model="form.datavisita" placeholder="Enter your name"/>
                </div>
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

  export default {
      name: 'Imoveis',
      data() {
        return {
          corretor: [],
          posicao: 0,
          // urlmarca: "https://cafeimobiliaria.com.br/dadoscorretor",
          // urlmarca: "https://www.cafeimobiliaria.com.br/dadoscorretor/api/imovel",
          urlmarca: "http://localhost:8080/api/imovel",
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
          options: {
              responsive: true,
              maintainAspectRatio: true,
              legend: {
                  display: false
              }
          },
          form: {
            cliente: "",
            codigo: "",
            datavisita: ""
          }
      }
    },
    components: {
        Progress,
        Bar
    }
  }
</script>
<style>
  /* @media (min-width: 1024px) {
    .universidade {
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
  } */
label {
  display: inline-block;
  margin-bottom: 0.5rem;
}
</style>
  