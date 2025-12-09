<script setup>
import { ref } from 'vue';
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
import ChatWindow from "./components/ChatWindow.vue";
import "@fontsource/open-sans"; // Defaults to weight 400.
export default {
  data() {
    return {
      corretor: "Sr. Café",
      corretorid: 0,
      ativo: this.$route.meta.usuarioativo, //this.$route.props.usuarioativo
      sidebar: this.$route.meta.sidebar,
      ativamenumobile: "",
      menuativo: localStorage.getItem('authUser') ? true : false,
      corretoresadmin: false
    }
  },
  components: {
    ChatWindow,
  },
  props: {
    title: String,
  },
  methods: {
    logout() {
      localStorage.removeItem('authUser');
      this.$router.push({
        name: "login"
      });
      this.menuativo = false;
    },
    handleFocusOut() {
      // console.log('out');
      this.ativamenumobile = "";
    },
    handleFocusOn() {
      // console.log('on');
      if (this.ativamenumobile == "") {
        this.ativamenumobile = " show";
      } else {
        this.ativamenumobile = "";
      }
    },
    // modal do chat
    openChatModal() { 
      const chatModal = new bootstrap.Modal(document.getElementById('chatModal'));
      chatModal.show();
    },
    closeChatModal() {
      const chatModal = bootstrap.Modal.getInstance(document.getElementById('chatModal'));
      chatModal.hide();
    },
  },
  mounted() {
  },
  watch:{
    $route (to, from){
        // this.show = false;
        // console.log(this.$route.meta);
        this.menuativo = this.$route.meta.usuarioativo;
        if (localStorage.getItem('authUser')) {
          var getnome = JSON.parse(localStorage.getItem('authUser'));
          this.corretor = getnome.nome;
          // console.log(this.$route.meta)
          this.menuativo = true;
        } else {
          this.menuativo = false;
          this.corretor = "Logar";
        }
    }
  },
  created() {
    if (localStorage.getItem('authUser')) {
      var getnome = JSON.parse(localStorage.getItem('authUser'));
      this.corretor = getnome.nome;
      this.corretorid = getnome.id;
      if (this.corretorid == 1 || this.corretorid == 10 || this.corretorid == 73  || this.corretorid == 43  || this.corretorid == 91) {
        this.corretoresadmin = true;
      }
      // console.log(this.$route.meta)
      this.menuativo = true;
    } else {
      this.menuativo = false;
    }
  },
}
</script>
<template>
  <!-- Nav Superior e Logo -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid ">
      <div class="navbar-nav left">
        <router-link class="navbar-brand logomarca" to="#">
          <img src="@/assets/logo/1.png" alt="" width="100">
        </router-link>
      </div>
      <button v-if="menuativo" class="navbar-toggler" type="button" @click="handleFocusOn">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div :class="'collapse navbar-collapse collapse' + ativamenumobile" id="navbarNav" @mouseleave="handleFocusOut()">
        <ul class="navbar-nav">
          <li class="nav-item menu-mobile v-b-tooltip.hover" style="text-align: end;margin-top: 10px;" v-if="$route.meta.usuarioativo">
            <!-- white-space: nowrap; -->
            <!-- Santa Maria, {{ new Date().getDate() }} de {{ new Date() }} de {{ new Date().getFullYear() }} -->
            Santa Maria, {{ hoje }}
            <br>
            Seja bem vindo, {{ corretor }}
            <br>
            <button class="btn btn-link nav-item v-b-tooltip.hover" @click="logout()" title="Sair"
              style="float: right; padding-right: 0px;font-weight: bolder;color: black;">
              Sair
            </button>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/">
              <font-awesome-icon icon="gauge" class="fa-2xl" /> Home
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start" v-if="corretoresadmin">
            <router-link class="nav-link" aria-current="page" to="/administracao">
              <font-awesome-icon icon="gauge" class="fa-2xl" /> Administração
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/atendimento">
              <font-awesome-icon icon="gauge" class="fa-2xl" /> Script de Atendimento
            </router-link>
          </li>
          <!-- <li class="nav-item menu-mobile btn-block m-0 p-2 text-start" v-if="corretoresadmin">
            <router-link class="nav-link" aria-current="page" to="/admvisitas">
              <font-awesome-icon icon="chart-column" class="fa-2xl" /> Relatórios de Visitas e Prospecção
            </router-link>
          </li> -->
          <!-- <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/registro-visitas">
              <font-awesome-icon icon="thumbtack" class="fa-2xl" /> Registrar as visitas
            </router-link>
          </li> -->
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/equacoes">
              <font-awesome-icon icon="house" class="fa-2xl" /> Projeção de resultados
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/numacros">
              <font-awesome-icon icon="house" class="fa-2xl" /> Placas
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/imoveis">
              <font-awesome-icon icon="house" class="fa-2xl" /> Imóveis Externos
            </router-link>
          </li>
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/precificacao">
              <font-awesome-icon icon="house" class="fa-2xl" /> Precificação
            </router-link>
          </li>
          <!-- <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/followup">
              <font-awesome-icon icon="house" class="fa-2xl" /> Follow-up de METAS
            </router-link>
          </li> -->
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/documentos">
              <font-awesome-icon icon="download" class="fa-2xl" /> Documentos
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
        <!-- <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
          <router-link class="nav-link" aria-current="page" to="/meus-resultados">
              <font-awesome-icon icon="user" class="fa-2xl" /> Meus resultados
            </router-link>
          </li> -->
          <!-- <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/analise-dados">
              <font-awesome-icon icon="gear" class="fa-2xl" /> Análise de dados
            </router-link>
          </li> -->
          <!-- <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/buscar-proprietario">
              <font-awesome-icon icon="search" class="fa-2xl" /> Buscar proprietário
            </router-link>
          </li> -->
          <li class="nav-item menu-mobile btn-block m-0 p-2 text-start">
            <router-link class="nav-link" aria-current="page" to="/pesquisar-cliente">
              <font-awesome-icon icon="briefcase" class="fa-2xl" /> Pesquisar cliente
            </router-link>
          </li>
        </ul>
      </div>
      <div class="navbar-nav right desktop">
        <div class="nav-item v-b-tooltip.hover" style="text-align: end;">
          <!-- Santa Maria, {{ new Date().getDate() }} de {{ new Date() }} de {{ new Date().getFullYear() }} -->
          Santa Maria, {{ hoje }}
          <br>
          Seja bem vindo, {{ corretor }}
          <br>
          <button class="btn btn-link nav-item v-b-tooltip.hover" @click="logout()" title="Sair"
            style="float: right; padding-right: 0px;font-weight: bolder;color: black;">
            Sair
          </button>
        </div>
        <!-- <div class="nav-item">
          
          </div> -->
      </div>
    </div>
  </nav>
  <!-- Menu Lateral -->
  <div  class="container text-center">
    <div class="row align-items-start">
      <div v-if="menuativo" class="col-md-2" style="">
        <div id="sidebar-cafe" class="d-flex flex-column flex-shrink-0 bg-light"
          style="width: 70%;float: right !important;margin-right: 15% !important;">
          <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li class="nav-item">
              <router-link to="/" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <br>
                <br>
                <br>
                <br>
                <font-awesome-icon icon="gauge" class="fa-2xl" />
                <br>
                <label class="label-icon">Dashboard</label>
              </router-link>
            </li>
            <li class="nav-item" v-if="corretoresadmin">
              <router-link to="/administracao" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Administração">
                <font-awesome-icon icon="gauge" class="fa-2xl" />
                <br>
                <label class="label-icon">Administração</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/atendimento" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Script de Atendimento">
                <font-awesome-icon icon="gauge" class="fa-2xl" />
                <br>
                <label class="label-icon">Script de Atendimento</label>
              </router-link>
            </li>
            <!-- <li class="nav-item" v-if="corretoresadmin">
              <router-link to="/admvisitas" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Administração">
                <font-awesome-icon icon="chart-column" class="fa-2xl" />
                <br>
                <label class="label-icon">Relatórios de Visitas e Prospecção</label>
              </router-link>
            </li> -->
            <!-- <li class="nav-item">
              <router-link to="/registro-visitas" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="thumbtack" class="fa-2xl" />
                <br>
                <label class="label-icon">Registrar as visitas</label>
              </router-link>
            </li> -->
            <li class="nav-item">
              <router-link to="/imoveis" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="house" class="fa-2xl" />
                <br>
                <label class="label-icon">Pesquisar Imóveis Externos</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/precificacao" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="money-bill-wave" class="fa-2xl" />
                <br>
                <label class="label-icon">Precificação</label>
              </router-link>
            </li>
            <!-- <li class="nav-item">
              <router-link to="/chat" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="comment" class="fa-2xl" />
                <br>
                <label class="label-icon">Chat</label>
              </router-link>
            </li> -->
            <li class="nav-item">
              <router-link to="/numacros" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="ticket" class="fa-2xl" />
                <br>
                <label class="label-icon">Placas e Marketplace</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/equacoes" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="chart-column" class="fa-2xl" />
                <br>
                <label class="label-icon">Projeção de Resultados 2025</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/download" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Script de Atendimento">
                <font-awesome-icon icon="download" class="fa-2xl" />
                <br>
                <label class="label-icon">Baixar Imagens</label>
              </router-link>
            </li>
            <!-- <li class="nav-item">
              <router-link to="/followup" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="list" class="fa-2xl" />
                <br>
                <label class="label-icon"> Follow-up de METAS</label>
              </router-link>
            </li> -->
            <li class="nav-item">
              <router-link to="/documentos" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="download" class="fa-2xl" />
                <br>
                <label class="label-icon"> Documentos</label>
              </router-link>
            </li>
            
            
            <li class="nav-item">
              <router-link to="/universidade" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="star" class="fa-2xl" />
                <br>
                <label class="label-icon">Universidade Café</label>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/solicitar-contrato" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="rectangle-list" class="fa-2xl" />
                <br>
                <label class="label-icon">Solicitar Contrato</label>
              </router-link>
            </li>
            <!-- <li class="nav-item">
              <router-link to="/meus-resultados" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="user" class="fa-2xl" />
                <br>
                <label class="label-icon">Meus resultados</label>
              </router-link>
            </li> -->
            <!-- <li class="nav-item">
              <router-link to="/analise-dados" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="gear" class="fa-2xl" />
                <br>
                <label class="label-icon">Análise de dados</label>
              </router-link>
            </li> -->
            <!-- <li class="nav-item">
              <router-link to="/buscar-proprietario" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="search" class="fa-2xl" />
                <br>
                <label class="label-icon">Buscar proprietário</label>
              </router-link>
            </li> -->
            <li class="nav-item">
              <router-link to="/pesquisar-cliente" class="nav-link py-3 border-bottom-inativar" aria-current="page"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                <font-awesome-icon icon="briefcase" class="fa-2xl" />
                <br>
                <label class="label-icon">Pesquisar cliente</label>
              </router-link>
            </li>
            <li class="nav-item">
              <br>
              <br>
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
  <!-- Vamos criar uma modal para o chat aqui, que avre a partir de um balão -->
  <!-- botão que abre a modal -->
   <button type="button" class="btn btn-primary efeito-pulsante-de-um-segundo" data-bs-toggle="modal" data-bs-target="#chatModal"
    style="position: fixed; bottom: 20px; right: 20px; border-radius: 50%; width: 60px; height: 60px; padding: 0px; z-index: 1050; background-color: #02244a;">
    <!-- <font-awesome-icon icon="comments" class="fa-2xl" /> -->
     <img src="@/assets/logo/icon-bg-dark.png" alt="Logo Avantor" style="height: 40px;">
    <!-- <font-awesome-icon icon="comment" class="fa-2xl" /> -->
  </button>
  <!-- Modal -->
  <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby ="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="chatModalLabel">
          <!-- ícone da empresa no canto -->
           <img src="@/assets/logo/icon-bg-dark.png" alt="Logo Avantor" style="height: 30px; margin-right: 10px;">
            Assistente Virtual Avantor
          </h5>
          <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">❌</button>
        </div>
        <div class="modal-body">
          <ChatWindow />
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
  /* position: fixed; */
  margin-bottom: 0px !important;
  bottom: 0px !important;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 56px;
}

body,
#app,
nav,
.navbar {
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
  box-shadow: 23.16px 17.453px 32.5px rgba(0, 0, 0, 0.16);
  ;
}

#sidebar-cafe:hover {
  cursor: pointer !important;
}

a {
  color: #2d460b !important;
}

#sidebar-cafe a:hover {
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
    /* margin-left: 250px; */
    padding: 29px;
  }

  .left {
    margin-left: 8% !important;
  }

  .right {
    margin-right: 10% !important;
  }
}

@media only screen and (max-width: 990px) {
  #sidebar-cafe {
    display: none !important;
  }

  .menu-mobile {
    display: block !important;
  }
}

/* navbar becomes mobile sidebar under lg breakpoint */
@media (max-width: 990px) {

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

  .nav-item button {
    margin-right: 0px !important;
  }

  .nav-link .svg-inline--fa {
    width: 25px !important;
  }

  .desktop {
    display: none;
  }
}
/* @media (min-width: 1400px) {
  .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    max-width: 1250px !important;
  }
} */
 /** deixar a modal invisível para destacar apenas o chatbot */
.modal {
  background-color: transparent !important;
  box-shadow: none !important;
}
.modal-header {
  background-color: #02244a !important;
  color: white !important;
}
/** aumentar a largura do chat */
.modal-dialog {
  max-width: 90%;
}
/* // criar efeito pulsante no botão do chat */
@keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 rgba(2, 36, 74, 0.7);
  }
  70% {
    box-shadow: 0 0 0 10px rgba(2, 36, 74, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(2, 36, 74, 0);
  }
}
.efeito-pulsante-de-um-segundo {
  animation: pulse 2s infinite;
}
</style>