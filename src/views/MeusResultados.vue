
import { Chart } from 'chart.js';

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
            <!-- <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
            </div>
            <sub>Em construção</sub>
            <hr> -->
            <br />
            <h3>Meus Resultados</h3>
            <br />
            <Chart></Chart>
        </div>
      </div>
    </div>
  </template>
  <script>
  import Chart from './Chart.vue'
  export default {
    components: {
      Chart
    },
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
  </style>
  