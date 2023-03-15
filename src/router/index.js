import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import Imoveis from '../views/Imoveis.vue';
import Universidade from '../views/Universidade.vue';
import SolicitarContrato from '../views/SolicitarContrato.vue';
import MeusResultados from '../views/MeusResultados.vue';
import AnaliseDados from '../views/AnaliseDados.vue';
import Visitas from '../views/Visitas.vue';
import BuscarProprietario from '../views/BuscarProprietario.vue';
import PesquisarCliente from '../views/PesquisarCliente.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
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
      component: Universidade
    },
    {
      path: '/imoveis',
      name: 'imoveis',
      component: Imoveis
    },
    {
      path: '/solicitar-contrato',
      name: 'solicitar-contrato',
      component: SolicitarContrato
    },
    {
      path: '/meus-resultados',
      name: 'meus-resultados',
      component: MeusResultados
    },
    {
      path: '/analise-dados',
      name: 'analise-dados',
      component: AnaliseDados
    },
    {
      path: '/registro-visitas',
      name: 'registro-visitas',
      component: Visitas
    },
    {
      path: '/buscar-proprietario',
      name: 'buscar-proprietario',
      component: BuscarProprietario
    },
    {
      path: '/pesquisar-cliente',
      name: 'pesquisar-cliente',
      component: PesquisarCliente
    },
  ]
})

export default router
