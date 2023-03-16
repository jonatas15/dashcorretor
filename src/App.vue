<script setup>
  import {ref} from 'vue';
  let num = ref(40);
  function formatDate(date) {
    let dia = date.getDate()
    let mes = [
      'janeiro', 'fevereiro', 'março', 'abril',
      'maio', 'junho', 'julho', 'agosto', 'setembro', 
      'outubro', 'novembro', 'dezembro'
    ][date.getMonth()]
    let ano = date.getFullYear()
    
    return `${dia} de ${mes} de ${ano}`
  }
  let hoje = formatDate(new Date())
</script>
<script>
  import "@fontsource/open-sans"; // Defaults to weight 400.
  export default {
    data() {
      return {
        corretor: "Sr. Café"
      }
    },
    methods: {
      logout() {
        localStorage.removeItem('authUser');
        this.$router.push({
          name: "login"
        });
      }
    },
    created() {
      if (localStorage.getItem('authUser')) {
        var getnome = JSON.parse(localStorage.getItem('authUser'));
        this.corretor = getnome.nome;
      }
    },
  }
</script>
<template>
  <!-- Nav Superior e Logo -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <router-link class="navbar-brand logomarca" to="#">
        <img src="@/assets/logo/1.png" alt="" width="200">
      </router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li
            class="nav-item menu-mobile v-b-tooltip.hover"
            style="
              text-align: end;
              margin-top: 10px;
              "
          >
            <!-- white-space: nowrap; -->
            <!-- Santa Maria, {{ new Date().getDate() }} de {{ new Date() }} de {{ new Date().getFullYear() }} -->
            Santa Maria, {{ hoje }}
            <br>
            Seja bem vindo, {{ corretor }}
            <br>
            <button
              class="btn btn-link nav-item v-b-tooltip.hover"
              @click="logout()"
              title="Sair"
              style="float: right; padding-right: 0px;font-weight: bolder;color: black;"
            >
              Sair
            </button>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/">
              <font-awesome-icon icon="gauge" class="fa-2xl" /> Home
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/imoveis">
              <font-awesome-icon icon="house" class="fa-2xl" /> Imóveis
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/universidade">
              <font-awesome-icon icon="star" class="fa-2xl" /> Universidade Café
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/solicitar-contrato">
              <font-awesome-icon icon="rectangle-list" class="fa-2xl" /> Solicitar Contrato
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/meus-resultados">
              <font-awesome-icon icon="user" class="fa-2xl" /> Meus resultados
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/analise-dados">
              <font-awesome-icon icon="gear" class="fa-2xl" /> Análise de dados
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/registro-visitas">
              <font-awesome-icon icon="thumbtack" class="fa-2xl" /> Registrar as visitas
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/buscar-proprietario">
              <font-awesome-icon icon="search" class="fa-2xl" /> Buscar proprietário
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/pesquisar-cliente">
              <font-awesome-icon icon="briefcase" class="fa-2xl" /> Pesquisar cliente
            </router-link>
          </li>
        </ul>
      </div>
      <div class="navbar-nav right desktop">
        <div
          class="nav-item v-b-tooltip.hover"
          style="text-align: end;"
        >
          <!-- Santa Maria, {{ new Date().getDate() }} de {{ new Date() }} de {{ new Date().getFullYear() }} -->
          Santa Maria, {{ hoje }}
          <br>
          Seja bem vindo, {{ corretor }}
          <br>
          <button
            class="btn btn-link nav-item v-b-tooltip.hover"
            @click="logout()"
            title="Sair"
            style="float: right; padding-right: 0px;font-weight: bolder;color: black;"
          >
            Sair
          </button>
        </div>
        <!-- <div class="nav-item">
          
        </div> -->
      </div>
    </div>
  </nav>
  <!-- Menu Lateral -->
  <div class="container text-center">
    <div class="row align-items-start">
      <div class="col-md-2" style="">
        <div id="sidebar-cafe" class="d-flex flex-column flex-shrink-0 bg-light" style="width: 70%;float: right !important;margin-right: 15% !important;">
          <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <br>
                <br>
                <br>
                <br>
                <font-awesome-icon icon="gauge" class="fa-2xl" />
                <br>
                <label class="label-icon">Dashboard</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/imoveis" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="house" class="fa-2xl" />
                <br>
                <label class="label-icon">Imóveis</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/universidade" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="star" class="fa-2xl" />
                <br>
                <label class="label-icon">Universidade Café</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/solicitar-contrato" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="rectangle-list" class="fa-2xl" />
                <br>
                <label class="label-icon">Solicitar Contrato</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/meus-resultados" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="user" class="fa-2xl" />
                <br>
                <label class="label-icon">Meus resultados</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/analise-dados" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="gear" class="fa-2xl" />
                <br>
                <label class="label-icon">Análise de dados</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/registro-visitas" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="thumbtack" class="fa-2xl" />
                <br>
                <label class="label-icon">Registrar as visitas</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/buscar-proprietario" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="search" class="fa-2xl" />
                <br>
                <label class="label-icon">Buscar proprietário</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/pesquisar-cliente" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="briefcase" class="fa-2xl" />
                <br>
                <label class="label-icon">Pesquisar cliente</label>
              </router-link>
            </li>
            <li class="nav-item">
              <br >
              <br >
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-10">
        <div class="main">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
  </div>
  <footer class="bg-light text-center">
    <!-- Copyright -->
    <div class="text-center p-3" style="">
      © {{ new Date().getFullYear() }} Copyright: ®
      <a class="text-dark" href="https://cafeinteligencia.com.br/">Café Negócios Imobiliário</a>
    </div>
    <!-- Copyright -->
  </footer>
</template>
<style >
  /**
  cor 1: #e3e3e3 fundo site
  cor 2: #ffffff fundo divs e menus
  cor 3: #2d460b grafico -ativo
  cor 3: #2d460b grafico -nao preenchido
  cor 3: #053a35 textos
  */
  footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 56px;
  }
  body, #app, nav, .navbar {
    background-color: #e3e3e3 !important;
    font-size: 13px;
    line-height: 18px;
    color: #053a35;
    font-weight: 400;
    font-family: "Open Sans";
    text-align: center;
  }
  
  #sidebar-cafe {
    display: block;
    background-color: white !important;
    border-top-left-radius: 90px;
    border-bottom-left-radius: 90px;
    box-shadow: 23.16px 17.453px 32.5px rgba(0,0,0,0.16);;
  }
  #sidebar-cafe:hover {
    cursor: pointer !important;
  }
  a {
    color: #2d460b !important;
  }
  #sidebar-cafe a:hover{
    font-size: 15px;
    color: green !important;
  }
  .label-icon {
    font-size: 13px !important;
    margin-top: 4px;
    font-weight: 100 !important;
  }
  #sidebar-cafe ul li.nav-item {
    margin-bottom: 15% !important;
  }
  #sidebar-cafe .label-icon {
    font-size: 10px;
    line-height: 18px;
    color: #053a35;
    font-weight: 400;
    font-family: "Open Sans";
    text-align: center;
  }
  .menu-mobile {
    display: none !important;
  }
  @media only screen and (min-width: 600px) {
    .logomarca {
      margin-left: 250px;
      padding: 50px;
    }
  }
  @media only screen and (max-width: 800px) {
    #sidebar-cafe {
      display: none !important;
    }
    .menu-mobile {
      display: block !important;
    }
  }
  /* navbar becomes mobile sidebar under lg breakpoint */
  @media (max-width: 992px) {
      
      .navbar-collapse.collapsing .navbar-nav {
          display: block;
          position: fixed;
          top: 0;
          bottom: 0;
          left: -70%;
          transition: all 0.1s ease;
          background-color: white !important;
          z-index: 100 !important;
          white-space: normal;
      }

      .navbar-collapse.show .navbar-nav {
          position: fixed;
          top: 0;
          bottom: 0;
          left: 0;
          flex-direction: column;
          height: auto;
          width: 70%;
          transition: left 0.1s ease;
          box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
          background-color: white !important;
          z-index: 100 !important;
      }
      .nav-link {
        font-weight: bolder !important;
        border-bottom: 1px solid lightgray;
        line-height: 30px;
        padding-left: 5%;
      }
      .nav-item {
        margin-right: 5% !important;
        text-transform: uppercase !important;
      }
      .nav-item button{
        margin-right: 0px !important;
      }
      .nav-link .svg-inline--fa {
        width: 25px !important;
      }
      .desktop {
        display: none;
      }
  }
</style>