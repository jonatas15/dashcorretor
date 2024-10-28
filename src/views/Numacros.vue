<template>
    <div class="container">
      <h2>Controle de Placas - Corretores [2024]</h2>
      <table class="table table-striped" v-if="corretores.length">
        <thead>
          <tr>
            <th>Corretor</th>
            <th v-for="mes in meses" :key="mes">{{ mes }}</th>
          </tr>
        </thead>
        <tbody class="table-striped">
          <tr v-for="corretor in corretores" :key="corretor.id">
            <td><strong>{{ corretor.nome }}</strong></td>
            <td v-for="(placas, index) in corretor.placasporcorretor" :key="index">
                <!-- v-model.number="corretor.placasPorMes[index]" -->
              <input
                type="number"
                v-model.number="placas.placas"
                class="form-control"
              />
              <!-- {{ placas.placas }} -->
            </td>
            
          </tr>
        </tbody>
      </table>
      <button @click="atualizarPlacas" class="btn btn-primary mt-3">Atualizar</button>
      <!-- <p v-else>Carregando corretores...</p> -->
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const corretores = ref([]);
  const meses = [
    // 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
  ];
  
  // Função para carregar os corretores da API
  async function carregarCorretores() {
    try {
      const response = await axios.get('https://www.cafeimobiliaria.com.br/dadoscorretor/api/corretor');
      const placares = await axios.get('https://www.cafeimobiliaria.com.br/dadoscorretor/api/numacros/view?id=235');
    //   console.log(JSON.parse(placares.data.placas));
      const placasporcorretor = JSON.parse(placares.data.placas);
      //.filter((den) => den.ativo == 1)
    //   response.data.filter((den) => den.ativo == 1)
      // Mapeia os corretores recebidos para incluir o array `placasPorMes` com valores padrão de 0
      corretores.value = response.data.filter((den) => den.ativo == 1).map(corretor => ({
        ...corretor,
        placasPorMes: Array(6).fill(0),
        placasporcorretor: placasporcorretor.filter((pl) => pl.corretor_id == corretor.id)
      }));
    } catch (error) {
      console.error('Erro ao carregar corretores:', error);
      alert('Houve um erro ao carregar a lista de corretores.');
    }
  }
  
  // Função para atualizar as placas na API
  async function atualizarPlacas() {
    try {
      const dadosParaEnvio = corretores.value.flatMap(corretor =>
        corretor.placasporcorretor.map((placas, index) => ({
          corretor_id: corretor.id,
          mes: meses[index],
          placas: placas.placas,
        }))
    );
    await axios.put('https://www.cafeimobiliaria.com.br/dadoscorretor/api/numacros/updateplacas', {
        id: 235,
        corretor_id: 1,
        mes_referencia: 1,
        placas: dadosParaEnvio
    });
  
      alert('Dados atualizados com sucesso!');
    } catch (error) {
      console.error('Erro ao atualizar as placas:', error);
      alert('Houve um erro ao atualizar as placas.');
    }
  }
  
  // Chama a função para carregar os corretores assim que o componente é montado
  onMounted(carregarCorretores);
  </script>
  
  <style scoped>
  .container {
    max-width: 800px;
    margin: auto;
  }
  .table {
    text-align: center;
  }
  input[type='number'] {
    width: 70px;
  }
  </style>
  