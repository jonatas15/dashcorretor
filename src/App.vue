<script setup>
  import {ref} from 'vue'
  let num = ref(40)
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
      <div class="col-md-2">
        <div id="sidebar-cafe" class="d-flex flex-column flex-shrink-0 bg-light" style="width: 80%;">
          <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <br>
                <br>
                <svg xmlns="http://www.w3.org/2000/svg" :width="num" :height="num" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16" aria-label="Dashboard">
                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" aria-label="Dashboard"/>
                </svg>
                <br>
                <span>Imóveis</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/universidade" class="nav-link py-3 border-bottom" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" :width="num" :height="num" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
                <br>
                <br>
                Universidade Café
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" :width="num" :height="num" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16" aria-label="Dashboard">
                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" aria-label="Dashboard"/>
                </svg>
                <br>
                <br>
                Solicitar Contrato
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" :width="num" :height="num" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16" aria-label="Dashboard">
                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" aria-label="Dashboard"/>
                </svg>
                <br>
                <br>
                Meus resultados
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" :width="num" :height="num" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16" aria-label="Dashboard">
                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" aria-label="Dashboard"/>
                </svg>
                <br>
                <br>
                Análise de dados
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" :width="num" :height="num" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16" aria-label="Dashboard">
                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" aria-label="Dashboard"/>
                </svg>
                <br>
                <br>
                Registrar as visitas
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" :width="num" :height="num" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16" aria-label="Dashboard">
                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" aria-label="Dashboard"/>
                </svg>
                <br>
                <br>
                Buscar proprietário
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" :width="num" :height="num" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16" aria-label="Dashboard">
                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" aria-label="Dashboard"/>
                </svg>
                <br>
                <br>
                Pesquisar cliente
              </router-link>
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
</template>
<style >
/**
 cor 1: #e3e3e3 fundo site
 cor 2: #ffffff fundo divs e menus
 cor 3: #2d460b grafico -ativo
 cor 3: #2d460b grafico -nao preenchido
 cor 3: #053a35 textos
*/
  body, #app, nav, .navbar {
    background-color: #e3e3e3 !important;
  }
  @media only screen and (min-width: 600px) {
    .logomarca {
      margin-left: 250px;
      padding: 50px;
    }
  }
  #sidebar-cafe {
    background-color: white !important;
    border-top-left-radius: 90px;
  }
  a {
    color: #2d460b !important;
  }
</style>