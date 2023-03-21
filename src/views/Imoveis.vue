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
            <div class="table-responsive-md">
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
          // urlmarca: "https://cafeimobiliaria.com.br",
          // urlmarca: "http://localhost",
          urlmarca: "",
        }
      },
      components: {
          Progress
      },
      created() {
        axios.get(this.urlmarca + "../jsons/cafeimoveiscorretor.json").then((res) => {
          console.log(res.data)
        }).catch((error) => {
          console.log(error);
        });
      }
    }
  </script>