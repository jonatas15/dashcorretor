<template>
  <div class="bg-white">
    <table class="table-auto w-full border-collapse border border-gray-300 bg-white">
      <thead>
        <tr>
          <th class="border px-4 py-2">Corretor</th>
          <th class="border px-4 py-2" v-for="mes in meses" :key="mes">{{ mes }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="corretor in corretores" :key="corretor.id">
          <td class="border px-4 py-2">{{ corretor.nome }}</td>
          <td
            class="border px-2 py-2"
            v-for="(valor, mes) in corretor.placas"
            :key="mes"
          >
            <input
              type="number"
              class="w-full text-center form-control"
              v-model.number="corretor.placas[mes]"
              @change="atualizarPlacas(corretor.id, strMes(mes), corretor.placas[mes])"
            />
            <!-- {{ strMes(mes) }} -->
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const meses = [
  "janeiro", "fevereiro", "março", "abril", "maio", "junho",
  "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"
];
function strMes(mes) {
  return meses[mes];
}

const corretores = ref([]);

const atualizarPlacas = async (corretorId, mes, quantidade) => {
  // Exemplo de chamada para a API do backend
  await fetch(`http://localhost:8080/placas/atualiza?corretorId=${corretorId}&mes=${mes}&quantidade=${quantidade}`);
};
const carregarDados = async () => {
  // Inicializa os registros no backend
  await fetch("http://localhost:8080/placas/initialize/");

  // Carrega os dados dos corretores e placas
  const response = await fetch("http://localhost:8080/placas");
  corretores.value = await response.json();
};
// fecha
onMounted(carregarDados);
</script>
