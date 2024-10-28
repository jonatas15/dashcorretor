import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import Administracao from '../views/Administracao.vue';
import Numacros from '../views/Numacros.vue';
import AdmVisitas from '../views/AdmVisitas.vue';
import Imoveis from '../views/Imoveis.vue';
import Followup from '../views/Followup.vue';
import Universidade from '../views/Universidade.vue';
import SolicitarContrato from '../views/SolicitarContrato.vue';
import MeusResultados from '../views/MeusResultados.vue';
import AnaliseDados from '../views/AnaliseDados.vue';
import Visitas from '../views/Visitas.vue';
import BuscarProprietario from '../views/BuscarProprietario.vue';
import PesquisarCliente from '../views/PesquisarCliente.vue';
import Documentos from '../views/Documentos.vue';
import Login from '../views/Login.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/administracao',
      name: 'administracao',
      component: Administracao,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/numacros',
      name: 'numacros',
      component: Numacros,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/admvisitas',
      name: 'admvisitas',
      component: AdmVisitas,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/universidade',
      name: 'universidade',
      component: Universidade,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/documentos',
      name: 'documentos',
      component: Documentos,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/imoveis',
      name: 'imoveis',
      component: Imoveis,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/followup',
      name: 'followup',
      component: Followup,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/solicitar-contrato',
      name: 'solicitar-contrato',
      component: SolicitarContrato,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/meus-resultados',
      name: 'meus-resultados',
      component: MeusResultados,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/analise-dados',
      name: 'analise-dados',
      component: AnaliseDados,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/registro-visitas',
      name: 'registro-visitas',
      component: Visitas,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/buscar-proprietario',
      name: 'buscar-proprietario',
      component: BuscarProprietario,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/pesquisar-cliente',
      name: 'pesquisar-cliente',
      component: PesquisarCliente,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: true 
      }
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: { 
        default: true,
        sidebar: false,
        usuarioativo: false 
      }
    },
  ]
});

router.beforeEach((to, from, next) => {
  if (to.name !== "login" && !localStorage.getItem('authUser')) {
    next({name: 'login'})
  } else {
    next();
  }
})

export default router
