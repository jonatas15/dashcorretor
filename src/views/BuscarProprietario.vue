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
        <div class="progress">
          <div
            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
            role="progressbar"
            aria-valuenow="75"
            aria-valuemin="0"
            aria-valuemax="100"
            style="width: 50%"
          ></div>
        </div>
        <sub>Em construção</sub>
        <hr />
        <h3>Buscar Proprietários</h3>
        <p>
          <div class="row my-1 campo-formulario">
            <div class="col-sm-2">
              <label class="for-label" for="nome">Nome:</label>
            </div>
            <div class="col-sm-10">
              <input type="text" id="nome" class="form-control" v-model="form.nome" placeholder=""/>
            </div>
          </div>
          <div class="row my-1 campo-formulario">
            <div class="col-sm-2">
              <label class="for-label" for="endereco">Endereço:</label>
            </div>
            <div class="col-sm-10">
              <input type="text" id="endereco" class="form-control" v-model="form.endereco" placeholder=""/>
            </div>
          </div>
          <div class="row my-1 campo-formulario">
            <div class="col-sm-2">
              <label class="for-label" for="linkmaps">Link Google Maps:</label>
            </div>
            <div class="col-sm-10">
              <input type="text" id="linkmaps" class="form-control" v-model="form.linkmaps" placeholder=""/>
            </div>
          </div>
          <div class="row my-1 campo-formulario" style="">
            <button class="btn btn-success" @click="cadastrar">Registrar</button>
          </div>
        </p>
        <p>
          <table class="table table-hover" id="my-table">
            <thead>
              <tr>
                <th scope="col">Nome</th>
                <th scope="col">Endereço</th>
                <th scope="col">Contato</th>
                <th scope="col">Documento</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="prop in proprietarios" :key="prop.id">
                <td>{{ prop.nome }}</td>
                <td>{{ prop.endereco }}</td>
                <td>{{ prop.telefone }}</td>
                <td>{{ prop.cpf }}</td>
              </tr>
            </tbody>
          </table>
        </p>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
  import axios from "axios";
  import "@fontsource/exo-2";
  import moment from 'moment';
  import VueBasicAlert from 'vue-basic-alert'
  export default {
      name: 'BuscarProprietarios',
      data() {
        return {
          corretor: [],
          idcorretor: '',
          proprietarios: [],
          urlproprietario: 'http://localhost:8080/api/proprietario',
          // urlproprietario: 'https://cafeimobiliaria.com.br/dadoscorretor/api/proprietario',
          form: {
            nome: "",
            endereco: "",
            linkmaps: ""
          }
        }
      },
      methods: {
        cadastrar() {
          axios.post("https://www.cafeimobiliaria.com.br/sistema/api/visita/create", {
            usuario_id: 1,
            data_visita: moment(String(this.form.datavisita)).format('YYYY-DD-MM'),
            observacoes: this.form.obs,
            codigo_imovel: this.form.codigo,
            nome_cliente: this.form.cliente,
            id_corretor: this.idcorretor,
            imobiliaria_parceria: this.form.imobiliaria
          }).then(response => {
            // console.log(response.status);
            this.$refs.alert.showAlert(
              'success', // There are 4 types of alert: success, info, warning, error
              'Sua visita foi cadastrada', // Message of the alert
              'Sucesso', // Header of the alert
              { iconSize: 35, // Size of the icon (px)
                iconType: 'solid', // Icon styles: now only 2 styles 'solid' and 'regular'
                position: 'center right' } // Position of the alert 'top right', 'top left', 'bottom left', 'bottom right'
            )
            this.form.nome = "";
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
        }
      },
      created() {
        if (localStorage.getItem('authUser')) {
          var getnome = JSON.parse(localStorage.getItem('authUser'));
          this.idcorretor = getnome.id;
        }
        axios.get(this.urlproprietario).then((res) => {
          // console.log(res.data)
          this.proprietarios = res.data.filter(
            d => d.corretor_id == 1 &&
            d.corretor_id !== "" &&
            d.corretor_id !== null
          );
          console.log(this.proprietarios)
        });
      },
        
    };
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
</style>
  