<template>
  <div class="container text-left">
    <vue-basic-alert 
      :duration="300"
      :closeIn="2000"
      ref="alert"
    />
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
        <!-- <div class="progress">
          <div
            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
            role="progressbar"
            aria-valuenow="80"
            aria-valuemin="0"
            aria-valuemax="100"
            style="width: 80%"
          ></div>
        </div>
        <sub>Em construção</sub>
        <hr /> -->
        <h3>Buscar Proprietários</h3>
        
          <div class="row my-1 campo-formulario">
            <div class="col-sm-2">
              <label class="for-label" for="nome"><font-awesome-icon icon="user" class="fa-2x" /> Nome:</label>
            </div>
            <div class="col-sm-10">
              <input type="text" id="nome" class="form-control" v-model="form.nome" placeholder=""/>
            </div>
          </div>
          <div class="row my-1 campo-formulario">
            <div class="col-sm-2">
              <label class="for-label" for="endereco"><font-awesome-icon icon="home" class="fa-2x" /> Endereço completo do imóvel:</label>
            </div>
            <div class="col-sm-10">
              <input type="text" id="endereco" class="form-control" v-model="form.endereco" placeholder=""/>
            </div>
          </div>
          <div class="row my-1 campo-formulario">
            <div class="col-sm-2">
              <label class="for-label" for="linkmaps"><font-awesome-icon icon="map-marked" class="fa-2x" /> Localização do imóvel no Google Maps (link):</label>
            </div>
            <div class="col-sm-10">
              <input type="text" id="linkmaps" class="form-control" v-model="form.linkmaps" placeholder=""/>
            </div>
          </div>
          <div class="row my-1 campo-formulario">
            <div class="col-sm-2">
              <label class="for-label" for="whatsapp">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-inline--fa fa-map-location fa-2x" viewBox="0 0 448 512">
                  <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                </svg> Whatsapp do Corretor:</label>
            </div>
            <div class="col-sm-10">
              <input type="cell" v-mask="'(##) #####-####'" id="whatsapp" class="form-control" v-model="form.whatsapp" placeholder=""/>
            </div>
          </div>
          <div class="row my-1 campo-formulario" style="">
            <button class="btn btn-info text-white fw-bolder w-100" @click="cadastrar">Solicitar</button>
          </div>
        
        <br>
        <br>
        <br>
          <!-- <h3>Lista</h3>
          <table class="table table-hover" id="my-table">
            <thead>
              <tr>
                <th scope="col">Nome</th>
                <th scope="col">Endereço</th>
                <th scope="col">Contato</th>
                <th scope="col">Documento</th>
                <th scope="col">Maps</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="prop in proprietarios" :key="prop.id">
                <td>{{ prop.nome }}</td>
                <td>{{ prop.endereco }}</td>
                <td>{{ prop.telefone }}</td>
                <td>{{ prop.cpf }}</td>
                <td><a :href="prop.linkmaps" target="_blank">🗺️</a></td>
              </tr>
            </tbody>
          </table> -->
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
          // urlproprietario: 'http://localhost:8080/api/proprietario',
          urlproprietario: 'https://www.avantorimoveis.com.br/dadoscorretor/api/proprietario',
          form: {
            nome: "",
            endereco: "",
            linkmaps: "",
            whatsapp: ""
          }
        }
      },
      components: {
        VueBasicAlert
      },
      methods: {
        cadastrar(self) {
          // var formData = new FormData();
          // formData.append('corretor_id', this.idcorretor);
          // formData.append('nome', this.form.nome);
          // formData.append('endereco', this.form.endereco);
          // formData.append('linkmaps', this.form.linkmaps);
          // formData.append('telefone', this.form.whatsapp);
          axios.post("https://www.avantorimoveis.com.br/dadoscorretor/api/proprietario/create", {
            corretor_id: this.idcorretor,
            nome: this.form.nome,
            endereco: this.form.endereco,
            linkmaps: this.form.linkmaps,
            telefone: this.form.whatsapp
          }).then(response => {
            // console.log(response.status);
            this.$refs.alert.showAlert(
              'success', // There are 4 types of alert: success, info, warning, error
              'As informações foram cadastradas', // Message of the alert
              'Sucesso', // Header of the alert
              { iconSize: 35, // Size of the icon (px)
                iconType: 'solid', // Icon styles: now only 2 styles 'solid' and 'regular'
                position: 'center right' } // Position of the alert 'top right', 'top left', 'bottom left', 'bottom right'
            )
            // this.form.nome = "";
            this.form.endereco = "";
            this.form.linkmaps = "";
            // this.form.whatsapp = "";
          }).catch(response => {
            // console.log(response);
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
          // console.log(getnome.celular)
          this.idcorretor = getnome.id;
          this.form.whatsapp = getnome.celular;
          this.form.nome = getnome.nome;
        }
        // axios.get(this.urlproprietario).then((res) => {
        //   // console.log(res.data)
        //   this.proprietarios = res.data.filter(
        //     d => d.corretor_id == this.idcorretor &&
        //     d.corretor_id !== "" &&
        //     d.corretor_id !== null
        //   );
        //   console.log(this.proprietarios)
        // });
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
  