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
            -- Basic Alert
            // duration of transistions (ms)
            // if you dont have this, you can close the alert manually
          -->
          <vue-basic-alert 
            :duration="300"
            :closeIn="2000"
            ref="alert"
          />
          <div class="vertical-center" style="width: 305px !important;">
            <h5 class="titulo-dash" style="">
              Veja como estipular suas<br>
              metas de maneiras alcançáveis.
            </h5>
            <!-- <a class="btn btn-transparente float-right" href="#">ver mais</a> -->
            <button class="btn btn-transparente float-right">ver mais</button>
          </div>
        </div>
        <div class="col-md-12 dash-corretor">
            <!-- <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%"></div>
            </div>
            <sub>Em construção</sub>
            <hr> -->
            <br />
            <h3>Registro de Visitas (Ref.: 2024)</h3>
            <br />
            <br />
            <!-- <p>Message is: {{ form.cliente }}</p> -->
            <!-- <input v-model="form.cliente" placeholder="edit me" /> -->
            <div class="container-fluid row">
              <div class="col-md-6 col-sm-12">
                <h4><strong>Cadastrar Nova Visita</strong></h4>
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitadata">Data da Visita:</label>
                  </div>
                  <div class="col-7 col-sm-5">
                    <input v-mask="'##/##/####'" ref="campodatavisita" type="text" id="visitadata" class="form-control" v-model="form.datavisita" placeholder="__/__/_____"/>
                  </div>
                  <div class="col-5 col-sm-4">
                    <button :class="'btn btn-' + stylebtnhoje" style="width: 100%" @click="dehoje()">
                      {{ botaodehoje }}
                    </button>
                  </div>
                </div>
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitacodimovel">Código do Imóvel:</label>
                  </div>
                  <div class="col-sm-9">
                    <input ref="codigoimv" type="text" id="visitacodimovel" class="form-control" v-model="form.codigo" placeholder="Código no site" :disabled="isFieldDisabled"/>
                  </div>
                  <div class="col-sm-12 py-2 float-start">
                    <input type="checkbox" class="mx-2 float-start" v-model="form.semcodigo" id="checksemcodigo" @change="actionsemcodigo">
                      <label class="fs-6 float-start" for="checksemcodigo" style="">
                        <b>Visita de Prospecção</b>    
                      </label>
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
                    <label class="for-label" for="visitaclientetelefone">Contato do Visitante:</label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" v-mask="'(##) #####-####'" id="visitaclientetelefone" class="form-control" v-model="form.clientetelefone" placeholder="Telefone do cliente/visitante"/>
                  </div>
                </div>
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitaimobparceira">imobiliaria Parceira:</label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" id="visitaimobparceira" class="form-control" v-model="form.imobiliaria" placeholder="Se houver"/>
                  </div>
                </div>
                <div class="row my-1 campo-formulario">
                  <div class="col-sm-3">
                    <label class="for-label" for="visitaobs">Observações:</label>
                  </div>
                  <div class="col-sm-9">
                    <textarea type="text" id="visitaobs" class="form-control" v-model="form.obs"/>
                  </div>
                </div>
                <!-- background-color: #198754 -->
                <div class="row my-1 campo-formulario" style="">
                  <div class="col-6 col-sm-6">
                    <button class="btn btn-success" @click="cadastrar">Cadastrar</button>
                    <br/>
                    <br/>
                    <input type="checkbox" v-model="form.checked" id="checkemsequencia">
                      <label for="checkemsequencia" style="margin-left: 5px">
                        <b>Em sequência</b>    
                      </label>
                    <!-- {{ form.checked }} -->
                  </div>
                  <div class="col-6 col-sm-6">
                    <button class="btn btn-warning" @click="limpar">Limpar os dados do formulário</button>
                  </div>
                  <div class="col-12">
                    <hr>
                    <p>
                      Em sequência: mantém os campos inseridos para mais cadastros em sequência, limpando apenas o campo código.
                    </p>
                  </div>
                </div>
                <!-- <div class="row my-1 campo-formulario" style="">
                </div> -->
              </div>
              <!-- Recebida as visitas, agora faremos a Tabela de Listagem -->
              <div class="col-md-6 col-sm-12 row">
                <h4><strong>Análises</strong></h4>
                <div class="col-md-12 col-sm-12">
                  <Line :data="{
                    labels: data.labels,
                    datasets: data.datasets
                  }" :options="options" />
                </div>
                <div class="row">
                  <!-- <div class="col-4"></div> -->
                  <div class="col-12" style="height: 210px !important;">
                    <!-- <center> -->
                    <Pie :data="{
                      labels: pizza.labels,
                      datasets: pizza.datasets
                    }" :options="pizzaoptions" />
                      <!-- </center> -->
                  </div>
                  <!-- <div class="col-4"></div> -->
                </div>
              </div>
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
                      <th scope="col" class="desktop">Observações</th>
                      <th scope="col" class="desktop">Imobiliária Parceira</th>
                      <th scope="col" class="desktop">Telefone</th>
                      <th scope="col">Convertido</th>
                      <th scope="col">Excluir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="visita in visitas" :key="visita.idvisita">
                      <td>{{ visita.dia_visita }}</td>
                      <td v-if="visita.codigo_imovel == '00000'">Prospecção</td>
                      <td v-else>{{ visita.codigo_imovel }}</td>
                      <td>{{ visita.nome_cliente }}</td>
                      <td class="desktop">{{ visita.observacoes }}</td>
                      <td class="desktop">{{ visita.imobiliaria_parceria }}</td>
                      <td class="desktop">{{ visita.campoextra }}</td>
                      <td>
                        <!-- {{ visita.convertido }} -->
                        <Toggle
                          :id="'visitacontrato_' + visita.idvisita"
                          v-model="visita.convertido"
                          v-bind="form.contrato"
                          class="toggle-blue"
                          @click="converter(visita.idvisita, Number(visita.convertido))"
                        />
                      </td>
                      <td>
                        <button class="btn btn-danger" @click="excluir(visita.idvisita)">x</button>
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
    ArcElement,
    BarElement,
    CategoryScale,
    LinearScale
  } from 'chart.js';
  import { Bar, Line, Pie } from 'vue-chartjs';

  ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend, ArcElement);

  import Toggle from '@vueform/toggle';

  import moment from 'moment';
  import VueBasicAlert from 'vue-basic-alert'

  export default {
      name: 'Imoveis',
      data() {
        return {
          corretor: [],
          botaodehoje: "Hoje",
          stylebtnhoje: "info",
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
          idcorretor: "",
          visitas: [],
          pizza: {
            labels: ['Convertidos', 'Não convertidos'],
            datasets: [
              {
                backgroundColor: ['green', 'gray'],
                data: [40, 20]
              }
            ]
          },
          pizzaoptions: {
            responsive: true,
            maintainAspectRatio: true,
            legend: {
              display: true,
              position: 'right',
              align: 'center'
            }
          },
          myStyles: {
              height: '200px',
              position: 'center',
              // width: '100%'
          },
          data: {
            labels: ['Jan', 'Fev', 'Mxxar', 'Abr'],
            datasets: [
              {
                label: "Visitas",
                backgroundColor: '#e3e3e3',
                borderColor: '#e3e3e3',
                data: [33, 78, 34, 67],
                fill: false,
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: {
              display: true
            }
          },
          isFieldDisabled: false,
          form: {
            cliente: "",
            clientetelefone: "",
            codigo: "",
            datavisita: "", // moment(Date()).format('DD/MM/YYYY'),
            marcado: true,
            semcodigo: false,
            contrato: {
              value: true,
              trueValue: 1,
              falseValue: 0,
              onLabel: 'SIM',
              offLabel: 'NÃO',
            },
            imobiliaria: "",
            obs: "",
            checked: true

          }
      }
    },
    components: {
        Progress,
        Bar,
        Pie,
        Toggle,
        Line,
        VueBasicAlert
    },
    methods: {
      actionsemcodigo() {
        if(this.form.semcodigo) {
          this.form.codigo = '00000';
          this.isFieldDisabled = true;
        } else {
          this.form.codigo = '';
          this.isFieldDisabled = false;
          // this.$refs.codigoimv.focus();
          // this.form.codigo.focus();
        }
        // this.toggleField();
      },
      toggleField() {
        this.isFieldDisabled = !this.isFieldDisabled;
      },
      avisaropovo (self) {
        axios.post("https://www.cafeimobiliaria.com.br/sistema/api/registro/enviar", {
          usuario_id: 1,
          data_visita: this.formataStringData(this.form.datavisita), //moment(String(this.form.datavisita)).format('Y-MM-D'),
          // data_visita: moment(String(this.form.datavisita)).format('YYYY-MM-DD'),
          observacoes: this.form.obs,
          codigo_imovel: this.form.codigo,
          nome_cliente: this.form.cliente,
          id_corretor: this.idcorretor,
          imobiliaria_parceria: this.form.imobiliaria,
          campoextra: this.form.clientetelefone.replace(/\D+/g, '')
        }).then(response => {
          // console.log(response.status);
          this.$refs.alert.showAlert(
            'success', 
            'Sua visita foi cadastrada',
            'Sucesso',
            {
              iconSize: 35,
              iconType: 'solid',
              position: 'center right'
            }
          )
          // this.toggleField();
        }).catch(response => {
          // console.log(response.status);
          this.$refs.alert.showAlert(
            'error', // There are 4 types of alert: success, info, warning, error
            'Sua visita não foi cadastrada; preencha o formulário corretamente', // Message of the alert
            'Erro', // Header of the alert
            { iconSize: 35, // Size of the icon (px)
              iconType: 'solid', // Icon styles: now only 2 styles 'solid' and 'regular'
              position: 'center center' } // Position of the alert 'top right', 'top left', 'bottom left', 'bottom right'
          )
        });
      },
      cadastrar (self) {
        // console.log("bora chamar a API");
        axios.post("https://www.cafeimobiliaria.com.br/sistema/api/visita/create", {
          usuario_id: 1,
          data_visita: this.formataStringData(this.form.datavisita), //moment(String(this.form.datavisita)).format('Y-MM-D'),
          // data_visita: moment(String(this.form.datavisita)).format('YYYY-MM-DD'),
          observacoes: this.form.obs,
          codigo_imovel: this.form.codigo,
          nome_cliente: this.form.cliente,
          id_corretor: this.idcorretor,
          imobiliaria_parceria: this.form.imobiliaria,
          campoextra: this.form.clientetelefone.replace(/\D+/g, '')
        }).then(response => {
          // console.log(response.status);
          this.$refs.alert.showAlert(
            'success', 
            'Sua visita foi cadastrada',
            'Sucesso',
            {
              iconSize: 35,
              iconType: 'solid',
              position: 'center right'
            }
          )
          if (this.form.checked) {
            this.form.codigo = "";
            // this.$refs.codigoimv.focus();
          } else {
            this.form.obs = "";
            this.form.codigo = "";
            this.form.cliente = "";
            this.idcorretor = "";
            this.form.imobiliaria = "";
            // this.toggleField();
          }
          this.form.semcodigo = false;
          this.isFieldDisabled = false;
          // this.toggleField();
        }).catch(response => {
          // console.log(response.status);
          this.$refs.alert.showAlert(
            'error', // There are 4 types of alert: success, info, warning, error
            'Sua visita não foi cadastrada; preencha o formulário corretamente', // Message of the alert
            'Erro', // Header of the alert
            { iconSize: 35, // Size of the icon (px)
              iconType: 'solid', // Icon styles: now only 2 styles 'solid' and 'regular'
              position: 'center center' } // Position of the alert 'top right', 'top left', 'bottom left', 'bottom right'
          )
        });
      },
      dehoje () {
        if (this.form.datavisita == "") {
          this.botaodehoje = "Outro dia";
          this.form.datavisita = moment(Date()).format('DD/MM/YYYY');
          this.stylebtnhoje = 'warning';
        } else {
          this.$refs.campodatavisita.focus();
          this.stylebtnhoje = 'info';
          this.botaodehoje = "Hoje";
          this.form.datavisita = "";
        }
      },
      limpar () {
        this.form.cliente = "";
        this.form.codigo = "";
        // this.form.datavisita = "";
        this.form.marcado = "";
        // this.form.contrato = "";
        this.form.imobiliaria = "";
        this.form.obs = "";
        this.$refs.codigoimv.focus();
      },
      converter (id, recebeinvertido) {
        axios.put("https://www.cafeimobiliaria.com.br/sistema/api/visita/update?id=" + id, {
          convertido: recebeinvertido
        }).then(response => {
          console.log(response);
          this.$refs.alert.showAlert(
            'success', // There are 4 types of alert: success, info, warning, error
            'Sua visita foi Atualizada', // Message of the alert
            'Sucesso', // Header of the alert
            { iconSize: 35, // Size of the icon (px)
              iconType: 'solid', // Icon styles: now only 2 styles 'solid' and 'regular'
              position: 'center right' } // Position of the alert 'top right', 'top left', 'bottom left', 'bottom right'
          )
        })
        this.$forceUpdate();
      },
      excluir (id) {
        axios.delete("https://www.cafeimobiliaria.com.br/sistema/api/visita/delete?id=" + id).then(response => {
          console.log(response);
          this.$refs.alert.showAlert(
            'success', // There are 4 types of alert: success, info, warning, error
            'Sua visita foi Excluida', // Message of the alert
            'Sucesso', // Header of the alert
            { 
              iconSize: 35, // Size of the icon (px)
              iconType: 'solid', // Icon styles: now only 2 styles 'solid' and 'regular'
              position: 'center right' 
            } // Position of the alert 'top right', 'top left', 'bottom left', 'bottom right'
          )
        })
        this.removerdalista(id);
      },
      removerdalista (id) {
        // console.log("devia remover o " + id);
        // this.visitas.splice(id, 1);
        let updateStudentList = this.visitas.filter((el) => el.idvisita !== id);
        this.visitas = updateStudentList;
      },
      formataStringData(data) {
        var dia  = data.split("/")[0];
        var mes  = data.split("/")[1];
        var ano  = data.split("/")[2];

        return ano + '-' + ("0"+mes).slice(-2) + '-' + ("0"+dia).slice(-2);
        // Utilizo o .slice(-2) para garantir o formato com 2 digitos.
      }
      // alerta() {
      //   console.log("alerta!!!");
      //   this.$refs.alert.showAlert(
      //         'success', // There are 4 types of alert: success, info, warning, error
      //         'This is the information of something you may know Success.', // Message of the alert
      //         'Success 200', // Header of the alert
      //         { iconSize: 35, // Size of the icon (px)
      //           iconType: 'solid', // Icon styles: now only 2 styles 'solid' and 'regular'
      //           position: 'top right' } // Position of the alert 'top right', 'top left', 'bottom left', 'bottom right'
      //       )
      //   }
    },
    created() {
      
      // console.log("Data formatada:");
      // console.log(this.formataStringData("15/05/2023"));
      // console.log("_________________________________________________");
      // console.log(moment(String(this.form.datavisita)).format('YYYY-DD-MM'));
      if (localStorage.getItem('authUser')) {
        var getnome = JSON.parse(localStorage.getItem('authUser'));
        this.idcorretor = getnome.idsistema;
        // console.log(getnome);
        axios.get(this.urlvisitas).then((res) => {
          // console.log(res.data)
          this.visitas = res.data.filter(
            d => d.id_corretor == this.idcorretor &&
            d.id_corretor !== "" &&
            d.id_corretor !== null &&
            d.data_visita.indexOf("2024") !== -1
          );
          /**
           for(let mc of this.corretor.macros) {
                this.corretorlabels.push(moment(String(mc.data)).format('DD/MM/YYYY'));
                for(let mc2 of this.corretor.macros) {
                    leadsrecebidos.push(mc2.leads_recebidos);
                    percentual_conversao.push(mc2.percentual_conversao);
                    quant_vendas_vgc.push(mc2.quant_vendas_vgc);
                   
                    quant_vendas_vgv.push(mc2.quant_vendas_vgv);
                    quant_visitas.push(mc2.quant_visitas);
                    quant_imoveis_agenciados.push(mc2.quant_imoveis_agenciados);
                }
            }
           */
          // console.log(this.visitas)
          var legendas = [];
          var meses = [
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
          var valores = [];
          // console.log(meses);
          for(let mes of meses) {
            var convertidos = 0;
            var naoconvertidos = 0;
            var contames = 0;
            for(let mc of this.visitas) {
              if (mc.mes == mes) {
                contames = contames + 1;
              }
              if (mc.convertido == 1) {
                convertidos += 1;
              } else {
                naoconvertidos += 1;
              }
            }
            if (contames > 0) {
              legendas.push(mes);
              valores.push(contames);
            }
          }
          // console.log(valores);
          // console.log(legendas);
          this.data.labels = legendas;
          this.data.datasets = [{
            label: "Visitas",
            backgroundColor: 'green',
            borderColor: 'green',
            data: valores,
            fill: false,
          }];
          this.pizza.datasets = [{
            backgroundColor: ['green', 'gray'],
            data: [convertidos, naoconvertidos]
          }];
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
    margin: 10px 0px !important;
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
  