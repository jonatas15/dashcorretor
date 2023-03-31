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
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 90%"></div>
            </div>
            <sub>Em construção</sub>
            <hr>
            <div class="table-responsive-md">
              <table class="table table-hover" id="my-table">
                  <thead>
                      <tr>
                      <th scope="col">Imóvel no Site</th>
                      <th scope="col">Url - Campanha</th>
                      <th scope="col">Acessos/Fevereiro</th>
                      <th scope="col">Visitas feitas</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="imv in imoveis">
                        <th scope="row">
                          <a :href="'https://cafeimobiliaria.com.br/imovel/' + imv.codigo" target="_blank">
                            PIN - {{ imv.codigo }}
                          </a>
                        </th>
                        <td>Acesso normal</td>
                        <td>{{imv.acessos}}</td>
                        <td>(In Dev.)</td>
                      </tr>
                  </tbody>
              </table>
              <!-- <b-pagination
                v-model="pagina"
                :total-rows="rows"
                :per-page="20"
                aria-controls="my-table"
            ></b-pagination> -->
            <ul class="pagination">
              <li class="page-item">
                <a v-if="pagina > 1" class="page-link" @click="paginarmenos()" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              <li v-for="page in paginas" class="page-item" :class="page == pagina ? ' active' : ''">
                <a class="page-link" @click="paginar(page)">{{page}}</a>
              </li>
              <li class="page-item">
                <a v-if="pagina < totalpage" class="page-link" @click="paginarmais()" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
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
          // urlmarca: "https://cafeimobiliaria.com.br/dadoscorretor",
          urlmarca: "https://www.cafeimobiliaria.com.br/dadoscorretor/api/imovel",
          // urlmarca: "http://localhost:8080",
          // urlmarca: "",
          imoveis: [],
          todosimoveis: [],
          pagina: 1,
          totalpage: 1,
          por_pagina: 25,
          paginas: [],
          corretor_id: 12
        }
      },
      components: {
          Progress
      },
      
      methods: {
        paginar(paginaescolhida) {
          this.pagina = paginaescolhida;
          var initpage = (this.pagina - 1) * this.por_pagina
          var fimdpage = initpage + this.por_pagina
          this.imoveis = this.todosimoveis.filter(d => d.corretor_id == this.corretor_id).slice(initpage, fimdpage);
        },
        paginarmais() {
          if (this.pagina > 0 && this.pagina < this.totalpage) {
            this.pagina = this.pagina + 1;
            var initpage = (this.pagina - 1) * this.por_pagina
            var fimdpage = initpage + this.por_pagina
            this.imoveis = this.todosimoveis.filter(d => d.corretor_id == this.corretor_id).slice(initpage, fimdpage);
          }
        },
        paginarmenos() {
          if (this.pagina > 0) {
            this.pagina = this.pagina - 1;
            var initpage = (this.pagina - 1) * this.por_pagina
            var fimdpage = initpage + this.por_pagina
            this.imoveis = this.todosimoveis.filter(d => d.corretor_id == this.corretor_id).slice(initpage, fimdpage);
            
          }
        }
      },
      created() {
        if (localStorage.getItem('authUser')) {
          var getnome = JSON.parse(localStorage.getItem('authUser'));
          this.corretor_id = getnome.id;
        }
        // axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
        axios.get(this.urlmarca).then((res) => {
          // console.log(res.data)
          this.todosimoveis = res.data.filter(d => d.corretor_id == this.corretor_id);
          this.totalpage = Math.ceil(Number(this.todosimoveis.length)/this.por_pagina);
          this.imoveis = res.data.filter(d => d.corretor_id == this.corretor_id).slice(0, this.por_pagina);
          for (let index = 0; index < this.totalpage; index++) {
            list.push(Number(index + 1)); 
          }
          this.paginas = list;
        }).catch((error) => {
          console.log(error);
        });
        var list=[];
      } 
    }
  </script>
<style>
  .page-link:hover {
    cursor: pointer !important;
  }
</style>
