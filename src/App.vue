<script setup>
import { ref } from "vue";
let num = ref(40);
function formatDate(date) {
  let dia = date.getDate();
  let mes = [
    "janeiro",
    "fevereiro",
    "março",
    "abril",
    "maio",
    "junho",
    "julho",
    "agosto",
    "setembro",
    "outubro",
    "novembro",
    "dezembro",
  ][date.getMonth()];
  let ano = date.getFullYear();

  return `${dia} de ${mes} de ${ano}`;
}
let hoje = formatDate(new Date());
</script>
<script>
import ChatWindow from "./components/ChatWindow.vue";
import "@fontsource/open-sans"; // Defaults to weight 400.
import { clearAuthSession, getAuthUser, isAdminUser } from "@/config/adminAccess";
export default {
  data() {
    return {
      chatativo: false,
      corretor: "Sr. Café",
      corretorid: 0,
      ativo: this.$route.meta.usuarioativo, //this.$route.props.usuarioativo
      sidebar: this.$route.meta.sidebar,
      ativamenumobile: "",
      menuativo: localStorage.getItem('authUser') ? true : false,
      corretoresadmin: false,
      sessionValidationIntervalId: null,
      corretordados: [],
      fotocorretor: "",
      caminhofoto: "",
      menuItems: [
        { id: "home", to: "/", icon: "gauge", mobileLabel: "Home", desktopLabel: "Dashboard", enabled: true, showMobile: true, showDesktop: true },
        { id: "administracao", to: "/administracao", icon: "gauge", mobileLabel: "Administração", desktopLabel: "Administração", enabled: true, showMobile: true, showDesktop: true, adminOnly: true },
        { id: "atendimento", to: "/atendimento", icon: "gauge", mobileLabel: "Script de Atendimento", desktopLabel: "Script de Atendimento", enabled: true, showMobile: true, showDesktop: true },
        { id: "equacoes", to: "/equacoes", icon: "chart-column", mobileLabel: "Projeção de resultados", desktopLabel: "Projeção de Resultados 2025", enabled: true, showMobile: true, showDesktop: true },
        { id: "numacros", to: "/numacros", icon: "ticket", mobileLabel: "Placas", desktopLabel: "Placas", enabled: true, showMobile: true, showDesktop: true },
        { id: "imoveis", to: "/imoveis", icon: "house", mobileLabel: "Imóveis Externos", desktopLabel: "Pesquisar Imóveis Externos", enabled: true, showMobile: true, showDesktop: true },
        { id: "precificacao", to: "/precificacao", icon: "money-bill-wave", mobileLabel: "Precificação", desktopLabel: "Precificação", enabled: true, showMobile: true, showDesktop: true },
        { id: "download", to: "/download", icon: "download", mobileLabel: "Baixar Imagens", desktopLabel: "Baixar Imagens", enabled: true, showMobile: false, showDesktop: true },
        { id: "documentos", to: "/documentos", icon: "download", mobileLabel: "Documentos", desktopLabel: "Documentos", enabled: true, showMobile: true, showDesktop: true },
        { id: "solicitar-contrato", to: "/solicitar-contrato", icon: "rectangle-list", mobileLabel: "Solicitar Contrato", desktopLabel: "Solicitar Contrato", enabled: true, showMobile: false, showDesktop: true },
        { id: "pesquisar-cliente", to: "/pesquisar-cliente", icon: "briefcase", mobileLabel: "Pesquisar cliente", desktopLabel: "Pesquisar cliente", enabled: true, showMobile: true, showDesktop: true }
      ]
    }
  },
  computed: {
    mobileMenuItems() {
      return this.menuItems.filter(item => this.isMenuVisible(item, "mobile"));
    },
    desktopMenuItems() {
      return this.menuItems.filter(item => this.isMenuVisible(item, "desktop"));
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
      clearAuthSession();
      this.$router.push({
        name: "login"
      });
      this.menuativo = false;
    },
    forceLogout(message = "") {
      clearAuthSession();
      this.menuativo = false;
      this.corretoresadmin = false;
      this.corretor = "Logar";
      this.corretordados = [];

      if (message) {
        alert(message);
      }

      if (this.$route.name !== "login") {
        this.$router.replace({ name: "login" });
      }
    },
    validateAdminSession(showMessage = false) {
      const authUser = getAuthUser();

      if (!authUser) {
        this.menuativo = false;
        return false;
      }

      if (!isAdminUser(authUser.id)) {
        this.forceLogout(showMessage ? "Seu acesso ao sistema foi revogado. Entre em contato com a administração." : "");
        return false;
      }

      this.corretor = authUser.nome;
      this.corretorid = authUser.id;
      this.corretordados = authUser;
      this.corretoresadmin = true;
      this.menuativo = true;

      return true;
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
      this.chatativo = true;
    },
    closeChatModal() {
      this.chatativo = false;
    },
    isMenuVisible(item, view) {
      if (!item.enabled) return false;
      if (item.adminOnly && !this.corretoresadmin) return false;
      if (view === "mobile") return item.showMobile !== false;
      return item.showDesktop !== false;
    },
    async verificaSeArquivoExiste(arquivo) {
      try {
        const response = await fetch(arquivo, { method: 'HEAD' });

        if (response.ok) {
          return arquivo;
        }

        return 'assets/fotos-corretores/foto-perfil.jpg';
      } catch (e) {
        return 'assets/fotos-corretores/foto-perfil.jpg';
      }
    }
  },
  watch:{
    $route (to, from){
        // this.show = false;
        // console.log(this.$route.meta);
        this.menuativo = this.$route.meta.usuarioativo;
        if (localStorage.getItem('authUser')) {
          if (!this.validateAdminSession()) {
            return;
          }

          var getnome = getAuthUser();
          // console.log(this.$route.meta)
          this.menuativo = true;
          const modalEl = document.getElementById('chatModal')
          const instance = bootstrap.Modal.getInstance(modalEl)
          if (instance) instance.hide()
          // pega a foto em /assets/fotos-corretores
          
        } else {
          this.menuativo = false;
          this.corretor = "Logar";
        }
    }
  },
  created() {
    if (localStorage.getItem('authUser')) {
      if (!this.validateAdminSession(true)) {
        return;
      }

      var getnome = getAuthUser();
      this.fotocorretor = getnome.jetimobid
          this.fotocorretor += ".jpg"
          // traz arquivo fotocorretor da pasta public/assets
          this.caminhofoto = `assets/fotos-corretores/${this.fotocorretor}`
          
          
          // verifica se arquivo existe, senão usa foto padrão
          // fetch(this.caminhofoto)
          //   .then(response => {
          //     if (!response.ok) {
          //       this.caminhofoto = 'assets/fotos-corretores/foto-perfil.jpg'
          //     }
          //   })
          //   .catch(() => {
          //     this.caminhofoto = 'assets/fotos-corretores/foto-perfil.jpg'
          //   })
      // console.log(this.$route.meta)
      this.menuativo = true;
    } else {
      this.menuativo = false;
    }
  },
  mounted() {
    this.sessionValidationIntervalId = window.setInterval(() => {
      if (localStorage.getItem('authUser')) {
        this.validateAdminSession();
      }
    }, 15000);
  },
  beforeUnmount() {
    if (this.sessionValidationIntervalId) {
      clearInterval(this.sessionValidationIntervalId);
    }
  }
}
</script>
<template>
  <!-- Nav Superior e Logo -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <div class="navbar-nav left">
        <router-link class="navbar-brand logomarca" to="#">
          <img src="@/assets/logo/1.png" alt="" width="100" />
        </router-link>
      </div>
      <button
        v-if="menuativo"
        class="navbar-toggler"
        type="button"
        @click="handleFocusOn"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        :class="'collapse navbar-collapse collapse' + ativamenumobile"
        id="navbarNav"
        @mouseleave="handleFocusOut()"
      >
        <ul class="navbar-nav">
          <li
            class="nav-item menu-mobile v-b-tooltip.hover"
            style="text-align: end; margin-top: 10px"
            v-if="$route.meta.usuarioativo"
          >
            <!-- white-space: nowrap; -->
            <!-- Santa Maria, {{ new Date().getDate() }} de {{ new Date() }} de {{ new Date().getFullYear() }} -->
            Santa Maria, {{ hoje }}
            <br />
            Seja bem vindo, {{ corretor }}
            <br />
            <button
              class="btn btn-link nav-item v-b-tooltip.hover"
              @click="logout()"
              title="Sair"
              style="
                float: right;
                padding-right: 0px;
                font-weight: bolder;
                color: black;
              "
            >
              Sair
            </button>
          </li>
          <li
            class="nav-item menu-mobile btn-block m-0 p-2 text-start"
            v-for="item in mobileMenuItems"
            :key="item.id"
          >
            <router-link
              class="nav-link"
              aria-current="page"
              :to="item.to"
            >
              <font-awesome-icon :icon="item.icon" class="fa-2xl" /> {{ item.mobileLabel }}
            </router-link>
          </li>
        </ul>
      </div>
      <div class="navbar-nav right desktop">
        <div class="nav-item v-b-tooltip.hover" style="text-align: end">
          <!-- Santa Maria, {{ new Date().getDate() }} de {{ new Date() }} de {{ new Date().getFullYear() }} -->
          Santa Maria, {{ hoje }}
          <br />
          Seja bem vindo, {{ corretor }}
          <br />
          <button
            class="btn btn-link nav-item v-b-tooltip.hover"
            @click="logout()"
            title="Sair"
            style="
              float: right;
              padding-right: 0px;
              font-weight: bolder;
              color: black;
            "
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
      <div v-if="menuativo" class="col-md-2" style="">
        <div
          id="sidebar-cafe"
          class="d-flex flex-column flex-shrink-0 bg-light"
          style="
            width: 70%;
            float: right !important;
            margin-right: 15% !important;
          "
        >
          <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li class="nav-item">
              <!-- foto do corretor pelo id -->
              <!-- {{ fotocorretor }} -->
                <div class="perfil-corretor">
                  <img :src="caminhofoto" @error="(e) => e.target.src = 'assets/fotos-corretores/foto-perfil.jpg'" />
                </div>
            </li>
            <li class="nav-item" v-for="item in desktopMenuItems" :key="item.id">
              <router-link
                :to="item.to"
                class="nav-link py-3 border-bottom-inativar"
                aria-current="page"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                :data-bs-original-title="item.desktopLabel"
              >
                <font-awesome-icon :icon="item.icon" class="fa-2xl" />
                <br />
                <label class="label-icon">{{ item.desktopLabel }}</label>
              </router-link>
            </li>
            <li class="nav-item">
              <br />
              <br />
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-10">
        <div class="main">
          <router-view :fotocorretor="caminhofoto"></router-view>
        </div>
      </div>
    </div>
  </div>
  <!-- Vamos criar uma modal para o chat aqui, que avre a partir de um balão -->
  <!-- botão que abre a modal -->
  <div class="chatbot-box" v-show="chatativo">
    <!-- botão fechar o chat -->
    <button
      type="button"
      class="btn-close btn-close-danger m-2"
      aria-label="Close"
      @click="closeChatModal"
      style="z-index: 9999 !important; color: red !important"
    >
      x
    </button>
    <ChatWindow />
  </div>
  <button
    type="button"
    class="btn btn-primary efeito-pulsante-de-um-segundo"
    @click="openChatModal"
    style="
      position: fixed;
      bottom: 20px;
      right: 20px;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      padding: 0px;
      z-index: 1050;
      background-color: #02244a;
    "
  >
    <!-- <font-awesome-icon icon="comments" class="fa-2xl" /> -->
    <img
      src="@/assets/logo/icon-bg-dark.png"
      alt="Logo Avantor"
      style="height: 40px"
    />
    <!-- <font-awesome-icon icon="comment" class="fa-2xl" /> -->
  </button>
  <!-- Modal -->
  <!-- <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby ="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="chatModalLabel">
           <img src="@/assets/logo/icon-bg-dark.png" alt="Logo Avantor" style="height: 30px; margin-right: 10px;">
            Assistente Virtual Avantor
          </h5>
          <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">❌</button>
        </div>
        <div class="modal-body">
          
        </div>
      </div>
    </div>
  </div> -->
  <div class="clearfix">
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
  </div>
  <footer class="bg-light text-center">
    <!-- Copyright -->
    <div class="text-center p-3" style="">
      © {{ new Date().getFullYear() }} Copyright: ®
      <a class="text-dark" href="https://cafeinteligencia.com.br/"
        >Café Negócios Imobiliário</a
      >
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
/* #chatModal .modal {
  background-color: transparent !important;
  box-shadow: none !important;
}
#chatModal .modal-header {
  background-color: #02244a !important;
  color: white !important;
}
#chatModal .modal-dialog {
  max-width: 90%;
} */
/* Chatbot fixo flutuante */
.chatbot-box {
  position: fixed;
  bottom: 90px;
  right: 20px;
  width: 460px;
  height: auto;
  padding: 0px;
  border-radius: 5px;
  background-color: #02244a;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  /* display: flex;
  align-items: center;
  justify-content: center; */
  cursor: pointer;
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
.perfil-corretor {
  width: 100%;
  height: 80px;
  display: flex;
  align-items: flex-start;
  justify-content: center;
  overflow: hidden;
  /* padding: 20px; */
  margin-top: 30px;
}
.perfil-corretor img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  object-position: top;
  border-radius: 80px;
}
</style>