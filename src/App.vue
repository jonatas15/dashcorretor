<script setup>
  import {ref} from 'vue'
  let num = ref(40)
</script>
<script>
  import "@fontsource/open-sans"; // Defaults to weight 400.
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
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link class="nav-link" aria-current="page" to="/">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/about">About</router-link>
          </li>
        </ul>
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
              <router-link to="/" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="rectangle-list" class="fa-2xl" />
                <br>
                <label class="label-icon">Solicitar Contrato</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="user" class="fa-2xl" />
                <br>
                <label class="label-icon">Meus resultados</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="gear" class="fa-2xl" />
                <br>
                <label class="label-icon">Análise de dados</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="thumbtack" class="fa-2xl" />
                <br>
                <label class="label-icon">Registrar as visitas</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="search" class="fa-2xl" />
                <br>
                <label class="label-icon">Buscar proprietário</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom-inativar" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="briefcase" class="fa-2xl" />
                <br>
                <label class="label-icon">Pesquisar cliente</label>
              </router-link>
            </li>
            <li class="nav-item">
              <br >
              <br >
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
  <div class="clearfiz"><br></div>
  <div class="clearfiz"><br></div>
  <div class="clearfiz"><br></div>
  <div class="clearfiz"><br></div>
  <footer class="bg-light text-center">
    <!-- Copyright -->
    <div class="text-center p-3" style="">
      © {{ new Date().getFullYear() }} Copyright:
      <a class="text-dark" href="https://mdbootstrap.com/">MDBootstrap.com</a>
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
  }
  a {
    color: #2d460b !important;
  }
  .label-icon {
    font-size: 12px;
    /* font-weight: bold; */
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
  }
</style>