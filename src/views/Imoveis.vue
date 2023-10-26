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
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 90%"></div>
            </div>
            <sub>Em construção</sub> -->
            <!-- <hr> -->
            <div class="table-responsive-md row">
              <h3>Imóveis</h3>
              <br />
              <br />
              <br />
              <!-- 
                Incluir campo de Filtros
                Acessos por imóvel: mostrar evolução pra cada imóvel
                  - Abrir detalhes do Imovel (Modal)
                  - É isso
              -->
              
              <br>
              <div class="col-md-4">
                <div class="form-group" style="text-align: left;">
                  <label for="pesquisa-imoveis" style="font-size: 15px; font-weight: 800;">Pesquisar por Código</label>
                  <input id="pesquisa-imoveis" class="form-control" v-model="searchText" @keyup="filtrar()">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" style="text-align: left;">
                  <label for="pesquisa-imoveis-periodo" style="font-size: 15px; font-weight: 800;">Período</label>
                  <select id="pesquisa-imoveis-periodo" class="form-control" v-model="searchTime" @change="filtrar()">
                    <option value="">Todo período</option>
                    <option value="Janeiro">Janeiro</option>
                    <option value="Fevereiro">Fevereiro</option>
                    <option value="Março">Março</option>
                    <option value="Abril">Abril</option>
                    <option value="Maio">Maio</option>
                    <option value="Junho">Junho</option>
                    <option value="Julho">Julho</option>
                    <option value="Agosto">Agosto</option>
                    <option value="Setembro">Setembro</option>
                    <option value="Outubro">Outubro</option>
                    <option value="Novembro">Novembro</option>
                    <option value="Dezembro">Dezembro</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" style="text-align: left;">
                  <label for="pesquisa-imoveis-ordem" style="font-size: 15px; font-weight: 800;">Ordenar por</label>
                  <select id="pesquisa-imoveis-ordem" class="form-control" v-model="searchOrder" @change=" filtrar()">
                    <option value="">Selecione</option>
                    <option value="codigo">Código</option>
                    <option value="acesso">Acessos</option>
                    <option value="visita">Visitas</option>
                  </select>
                </div>
              </div>
              <div class="form-group" style="text-align: right;padding: 10px;">
                <!-- <button
                  type="button"
                  class="btn btn-primary"
                  @click="showModal"
                >
                  Imóveis mais acessados
                </button> -->

                <Modalimovel
                  v-show="isModalVisible"
                  @close="closeModal"
                >
                  <template v-slot:header>
                    <h3>Detalhes do Imóvel  {{ imovelselecionadocodigo }}</h3>
                  </template>

                  <template v-slot:body>
                    <div class="row">
                      <div class="col-md-4">
                        <img :src="thumbdoimovel" alt="" style="width: 100%">
                      </div>
                      <div class="col-md-8">
                        <h4>Acessos no site</h4>
                        <Bar :title="'gráfico'" :data="{
                          labels: graflabels,
                          datasets: [
                            {
                              label: 'Acessos',
                              backgroundColor: '#2d460b',
                              data: grafvalues
                            }
                          ]
                        }" :options="options" />
                      </div>
                      <div class="col-md-12">
                        <br />
                        <br />
                      </div>
                      <div class="col-md-1"></div>
                      <div class="col-md-6">
                        <!-- {{ tabelavisitas }} -->
                        <h4>Visitas ao Imóvel</h4>
                        <table class="table table-hover" id="my-table">
                          <thead>
                            <tr>
                              <th scope="col">Período</th>
                              <th scope="col">Nº de visitas</th>
                              <th scope="col">Conversões (form)</th>
                              <th scope="col">Conversões (whats)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="visita in tabelavisitas" :key="visita">
                              <th scope="row">
                                {{ visita.periodo }}
                              </th>
                              <td scope="row">
                                {{ visita.visitas }}
                              </td>
                              <td scope="row">
                                {{ visita.convfrm }}
                              </td>
                              <td scope="row">
                                {{ visita.convwht }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-1"></div>
                      <div class="col-md-4">
                        <h4><strong>Mais Informações</strong></h4>
                        <!-- {{ tabelavisitas }} -->
                        <table class="table table-hover" id="my-table">
                          <tbody>
                            <tr>
                              <th scope="row">
                                Valor de Venda
                              </th>
                              <td scope="row">
                                {{ valorimovelnamodal }}
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">
                                Valor de Aluguel
                              </th>
                              <td scope="row">
                                {{ valorimovelnamodalaluguel }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <a 
                          class="btn btn-primary"
                          :href="'https://www.cafeimobiliaria.com.br/imovel/' + imovelselecionadocodigo"
                          target="_blank"
                          style="color: white !important; font-weight: bolder;"
                        >Ir pro site</a>
                      </div>
                    </div>
                  </template>

                  <template v-slot:footer>
                    Confira na tabela para dados de cada imóvel
                  </template>
                </Modalimovel>
              </div>
              <br>
              <!-- <ul>
                <li v-repeat="users | filterBy searchText">{{ name }}</li>
              </ul> -->
              <div v-show="carregando">
                <img src="@/assets/actions/please-wait.gif" />
              </div>
              <table class="table table-hover" id="my-table">
                <thead>
                  <tr>
                    <th scope="col">Imóvel no Site</th>
                    <th scope="col">Url - Campanha</th>
                    <th scope="col">Acessos</th>
                    <th scope="col">Visitas feitas</th>
                    <th scope="col">Período</th>
                    <!-- <th scope="col">convwht</th> -->
                    <!-- <th scope="col">convpag</th> -->
                    <th scope="col">Detalhes</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="imv in imoveis" :key="imv">
                    <th scope="row">
                      <a :href="'https://cafeimobiliaria.com.br/imovel/' + imv.codigo" target="_blank">
                        {{ imv.codigo }}
                      </a>
                    </th>
                    <td>Acesso normal</td>
                    <td>{{imv.acessos}}</td>
                    <td>{{imv.visitas}}</td>
                    <td>{{imv.periodo}}</td>
                    <!-- <td>{{imv.convwht}}</td> -->
                    <!-- <td>{{imv.convpag}}</td> -->
                    <td>
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="showImovel(imv)"
                      >
                        Ver
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- <b-pagination
                v-model="pagina"
                :total-rows="rows"
                :per-page="20"
                aria-controls="my-table"
            ></b-pagination> -->
            <ul class="pagination" style="display: contents !important;">
              <li class="page-item">
                <a v-if="pagina > 1" class="page-link" @click="paginarmenos()" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                  {{ pagina - 1 }}
                </a>
              </li>
              <!-- <li v-for="page in paginas" class="page-item" :class="page == pagina ? ' active' : ''" :key="page">
                <a class="page-link" @click="paginar(page)">{{page}}</a>
              </li> -->
              <li class="page-item"><a class="page-link active">{{ pagina }}</a></li>
              <li class="page-item">
                <a v-if="pagina < totalpage" class="page-link" @click="paginarmais()" aria-label="Next">
                  {{ pagina + 1 }}
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

    import Modalimovel from '../components/Modalimovel.vue';

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
            isModalVisible: false,
            carregando: false,
            tabelavisitas: [],
            corretor: [],
            posicao: 0,
            valorimovelnamodal: "Indefinido",
            valorimovelnamodalaluguel: "Indefinido",
            imovelselecionadocodigo: "Indefinido",
            searchText: "",
            searchTime: "",
            searchOrder: "acesso",
            // urlmarca: "https://cafeimobiliaria.com.br/dadoscorretor",
            // urlmarca: "https://www.cafeimobiliaria.com.br/dadoscorretor/api/imovel",
            urlmarca: "https://www.cafeimobiliaria.com.br/sistema/registrocampanhas/retornarapido",
            // urlmarca: "",
            imoveis: [],
            todosimoveis: [],
            filtrados: [],
            thumbdoimovel: '',
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
            }
        }
      },
      components: {
          Progress,
          Bar,
          Modalimovel
      },
      
      methods: {
        paginar(paginaescolhida) {
          this.pagina = paginaescolhida;
          var initpage = (this.pagina - 1) * this.por_pagina
          var fimdpage = initpage + this.por_pagina
          this.imoveis = this.filtrados.slice(initpage, fimdpage);
        },
        paginarmais() {
          if (this.pagina > 0 && this.pagina < this.totalpage) {
            this.pagina = this.pagina + 1;
            var initpage = (this.pagina - 1) * this.por_pagina
            var fimdpage = initpage + this.por_pagina
            this.imoveis = this.filtrados.slice(initpage, fimdpage);
          }
        },
        paginarmenos() {
          if (this.pagina > 0) {
            this.pagina = this.pagina - 1;
            var initpage = (this.pagina - 1) * this.por_pagina
            var fimdpage = initpage + this.por_pagina
            this.imoveis = this.filtrados.slice(initpage, fimdpage);
            
          }
        },
        filtrar () {
          this.paginar(1);
          this.filtrados = this.todosimoveis.filter(
            d => d.codigo.indexOf(this.searchText) != -1 &&
            (this.searchTime == "" || d.periodo == this.searchTime)
          );
          // Definições de Ordenamento
          switch (this.searchOrder) {
            case 'codigo':
              this.filtrados = this.filtrados.sort((t1, t2) => t1.codigo < t2.codigo ? 1 : -1);
              break;
            case 'acesso':
              this.filtrados = this.filtrados.sort((t1, t2) => t1.acessos < t2.acessos ? 1 : -1);
              break;
            case 'visita':
              this.filtrados = this.filtrados.sort((t1, t2) => t1.visitas < t2.visitas ? 1 : -1);
              break;
            default:
              this.filtrados = this.filtrados.sort((t1, t2) => t1.periodo < t2.periodo ? 1 : -1);
              break;
          }
          // Definições de Ordenamento
          this.totalpage = Math.ceil(Number(this.filtrados.length)/this.por_pagina);
          this.imoveis = this.filtrados.slice(0, this.por_pagina);
          var list = [];
          for (let index = 0; index < this.totalpage; index++) {
            list.push(Number(index + 1)); 
          }
          this.paginas = list;
          // this.todosimoveis = this.todosimoveis.filter(d => d.corretor_id == this.corretor_id && d.codigo == this.searchText);
        },
        // ordenar() {
        //   this.paginar(1);
        //   this.filtrados = this.todosimoveis.filter(
        //     d => d.codigo.indexOf(this.searchText) != -1 &&
        //     (this.searchTime == "" || d.periodo == this.searchTime)
        //   ).sort((t1, t2) => t1.acessos < t2.acessos ? 1 : -1);
        //   this.totalpage = Math.ceil(Number(this.filtrados.length)/this.por_pagina);
        //   this.imoveis = this.filtrados.slice(0, this.por_pagina);
        //   var list = [];
        //   for (let index = 0; index < this.totalpage; index++) {
        //     list.push(Number(index + 1)); 
        //   }
        //   this.paginas = list;
        // },
        showModal() {
          // console.log("devia");
          this.isModalVisible = true;
        },
        showImovel(imv) {
          // console.log("detalhes imovel");
          this.isModalVisible = true;
          this.thumbdoimovel = imv.imagem;
          var eixox = [];
          var eixoy = [];
          var visit = [];
          var prografico = this.todosimoveis.filter(d => d.codigo == imv.codigo);
          prografico.forEach(element => {
            // console.log(element.codigo);
            // console.log(element.acessos);
            eixox.push(element.periodo);
            eixoy.push(element.acessos);
            visit.push({
              periodo: element.periodo,
              visitas: element.visitas,
              convfrm: element.convwht,
              convwht: element.convpag
            });
          });
          this.graflabels = eixox;
          this.grafvalues = eixoy;
          this.tabelavisitas = visit;
          this.valorimovelnamodal = "R$ " + Math.round(imv.venda).toLocaleString();
          this.valorimovelnamodalaluguel = "R$ " + Math.round(imv.locacao).toLocaleString();
          this.imovelselecionadocodigo = imv.codigo;
        },
        closeModal() {
          // console.log("nao devia");
          this.isModalVisible = false;
        }
      },
      created() {
        this.carregando = true;
        if (localStorage.getItem('authUser')) {
          var getnome = JSON.parse(localStorage.getItem('authUser'));
          // console.log(getnome)
          this.corretor_id = getnome.jetimobid;
        }
        // axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
        axios.get(this.urlmarca).then((res) => {
          // console.log(res.data)
          this.todosimoveis = res.data.filter(
            d => d.codigo != ""
          );
          // this.todosimoveis = res.data.filter(
          //   d => d.corretor_id == this.corretor_id &&
          //   d.corretor_id !== "" &&
          //   d.corretor_id !== null
          // );
          this.totalpage = Math.ceil(Number(this.todosimoveis.length)/this.por_pagina);
          this.filtrados = this.todosimoveis;
          this.filtrados.sort((t1, t2) => t1.acessos < t2.acessos ? 1 : -1)
          this.imoveis = this.todosimoveis.slice(0, this.por_pagina);
          // console.log(this.corretor_id)
          // console.log(this.imoveis)
          // var prografico = res.data.filter(d => d.corretor_id == this.corretor_id && Number(d.acessos) > 20);
          for (let index = 0; index < this.totalpage; index++) {
            list.push(Number(index + 1)); 
          }
          this.paginas = list;
          // var eixox = [];
          // var eixoy = [];
          // prografico.forEach(element => {
          //   // console.log(element.codigo);
          //   // console.log(element.acessos);
          //   eixox.push(element.codigo);
          //   eixoy.push(element.acessos);
          // });
          // this.graflabels = eixox;
          // this.grafvalues = eixoy;
          // console.log(this.graflabels)
          // console.log(this.grafvalues)
          // this.chartData.labels = this.graflabels;
          // this.chartData.datasets.data = this.grafvalues;
          this.carregando = false;
        }).catch((error) => {
          console.log(error);
        });
        var list=[];
        // this.carregando = false;
        this.filtrar();
      }
    }
  </script>
<style>
  .page-link:hover {
    cursor: pointer !important;
  }
</style>
