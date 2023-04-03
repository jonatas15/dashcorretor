<template>
    <div class="container text-left">
      <div class="row align-items-start">
        <div class="col-md-12 banner" style="position: relative;">
          <!-- <img src="src/assets/banner/banner-1.png" /> -->
          <div class="contem-vertical-center">
          <div class="vertical-center" style="padding: 5% !important; text-align: left !important;">
            <h3 style="font-weight: bolder;">FAÇA O LOGIN</h3>
            <br>
            <form v-on:keyup.enter="envia">
                <div class="form-group">
                    <p v-if="errors.length">
                        <b>Por favor, corrija o(s) seguinte(s) erro(s):</b>
                        <ul>
                        <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </p>
                </div>
                <div class="form-group">
                    <!-- <label for="exampleInputEmail1">Email address</label> -->
                    <!-- :class="{ 'form-group--error': form.email.$error }" -->
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        aria-describedby="emailHelp"
                        placeholder="Seu Email"
                        v-model="form.email"
                    >
                    <small id="emailHelp" class="form-text text-muted">Informe seu email cadastrado</small>
                </div>
                <br>
                <div class="form-group">
                    <!-- <label for="exampleInputPassword1">Password</label> -->
                    <!-- :class="{ 'form-group--error': form.password.$error }" -->
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        placeholder="Senha"
                        v-model="form.password"
                    >
                    <small id="emailHelp" class="form-text text-muted">Informe sua senha</small>
                </div>
                
                <!-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Lembre-me</label>
                </div> -->
            </form>
            <button type="submit" @click="envia" class="btn btn-primary">Entrar</button>
          </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  <script>
//   import {required, minLength, email} from "vuelidate";
  import axios from "axios";
  export default {
    name: 'login',
    data() {
        return {
            apibase: 'http://localhost:8080/api/corretor',
            // apibase: 'https://www.cafeimobiliaria.com.br/dadoscorretor/api/corretor',
            errors: [],
            corretores: [],
            form: {
                email: "",
                password: "",
            }
        }
    },
    methods: {
        checkForm: function (e) {
            if (this.form.email !== '' && this.form.password !== '') {
                return true;
                // console.log("agora vai")
            }
            this.errors = [];
            
            if (!this.form.email) {
                this.errors.push('O email é obrigatório.');
            }
            if (!this.form.password) {
                this.errors.push('A senha é necessária');
            }
            // return false;
                
            e.preventDefault();
        },
        envia: function (e) {
            if (this.checkForm(e)) {
                this.errors = [];
                // console.log("agora vai")
                axios.get(this.apibase)
                    .then(response => {
                    this.corretores = response.data
                    // console.log(this.corretores)
                    for(let u of this.corretores) {
                        if (this.form.email == u.email && this.form.password == u.registro) {
                            // console.log("usuário válido");
                            localStorage.setItem('authUser', JSON.stringify(u));
                            this.$router.push({
                                name: 'home'
                            });
                        }
                    }
                    this.clearForm();
                    this.errors.push('Usuário ou senha inválidos');
                })
            } else {
                // console.log("agora não vai")
                // return false;
                this.clearForm();
                this.errors.push('Usuário ou senha inválidos');
            }
            // return false;
        },
        clearForm () {
            this.form = {
                email: "",
                password: "",
            }
        }
    }
  }
  </script>
  <style scoped>
  /* @media (min-width: 1024px) {
    .universidade {
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
  } */
  .banner {
    padding: 10% !important;
    height: 500px !important;
    background-size: auto 100%;
    background-position: 80%;
    background-repeat: no-repeat !important;
  }
  .contem-vertical-center {
      background-color: rgba(0 ,0 , 0, .4) !important;
      height: 100% !important;
      width: 320px;
      border-top-left-radius: 30px !important;
      border-bottom-left-radius: 30px !important;
      top: 0% !important;
      left: 0% !important;
      position: absolute !important;
      /* padding: 100px !important; */
  }
  .vertical-center {
    margin: 0 !important;
    color: whitesmoke !important;
    position: absolute !important;
    top: 50% !important;
    left: 0% !important;
    -ms-transform: translateY(-50%) !important;
    transform: translateY(-50%) !important;
    margin: 0 10% !important;
  }
  .vertical-center input {
    background-color: rgba(255 ,255 , 255, .5) !important;
  }
  @media only screen and (max-width: 800px) {
    .banner {
        padding: 10% !important;
        height: 500px !important;
        background-size: auto 100%;
        background-position: 50% !important;
        background-repeat: no-repeat !important;
    }
    .contem-vertical-center {
        background-color: rgba(0 ,0 , 0, .6) !important;
        height: 100% !important;
        width: 100% !important;
        border-radius: 30px !important;
        top: 0% !important;
        left: 0% !important;
        position: absolute !important;
        /* padding: 100px !important; */
    }
    .vertical-center {
        margin: 0 !important;
        color: whitesmoke !important;
        position: absolute !important;
        top: 50% !important;
        left: 0% !important;
        -ms-transform: translateY(-50%) !important;
        transform: translateY(-50%) !important;
        margin: 0 10% !important;
    }
  }
  .text-muted {
    color: white !important;
  }
  </style>
  