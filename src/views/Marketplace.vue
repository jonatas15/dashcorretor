<template>
  <div class="bg-white pt-5 w-full" style="border-top-right-radius: 90px">
    <br>
    
    <div class="btn-group" role="group" aria-label="Basic example">
      <router-link to="/numacros" class="btn btn-secondary text-white fw-bolder">Placas</router-link>
      <router-link to="/marketplace" class="btn btn-primary text-white fw-bolder">Marketplace</router-link>
    </div>
    <hr>
    <h4><strong>Marketplace</strong></h4>
    <!-- FILTROS -->
    <div class="border px-4 py-2 pb-3 d-flex align-items-center">
      <label class="me-2">Corretor:</label>
      <select v-model="selectedCorretor" class="form-select me-3" style="width: 250px;">
        <option value="">Todos</option>
        <option v-for="c in corretores" :key="c.id" :value="c.id">{{ c.nome }}</option>
      </select>

      <label class="me-2">Mês:</label>
      <select v-model="selectedMes" class="form-select me-3" style="width: 200px;">
        <option value="">Todos</option>
        <option value="1_trimestre">1º Trimestre</option>
        <option value="2_trimestre">2º Trimestre</option>
        <option value="3_trimestre">3º Trimestre</option>
        <option value="4_trimestre">4º Trimestre</option>
        <option v-for="(m, idx) in meses" :key="m" :value="idx">{{ abrevia(m, 3) }} ({{ m }})</option>
      </select>

      <button class="btn btn-outline-secondary" @click="resetFiltros">Limpar filtros</button>
    </div>
    <!-- TABELA (admin) -->
    <table v-if="useradmin" class="table table-striped mt-5 w-full border-collapse border border-gray-300 bg-white md-table">
      <thead>
        <tr>
          <th class="border px-4 py-2 pb-3"><b>Corretor</b></th>
          <th
            v-for="i in monthIndices"
            :key="i"
            class="border px-4 py-2 pb-3"
          >
            <b>{{ abrevia(meses[i], 3) }}</b>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="corretor in filteredCorretores" :key="corretor.id" class="super-tr">
          <td class="border px-4 py-2">{{ corretor.nome }}</td>
          <td
            class="border px-2 py-2"
            v-for="i in monthIndices"
            :key="i"
          >
            <div v-if="placasInputs[`${corretor.id}-${meses[i]}`]">
              <strong style="color: red;" v-if="placasInputs[`${corretor.id}-${meses[i]}`].filter(item => item && item.trim() !== '').length">
                {{ placasInputs[`${corretor.id}-${meses[i]}`].filter(item => item && item.trim() !== '').length }}
              </strong>
              <span v-else>
                {{ placasInputs[`${corretor.id}-${meses[i]}`].filter(item => item && item.trim() !== '').length }}
              </span>
            </div>
            <span v-else>0</span>
            <!-- {{ placasInputs[`${corretor.id}-${strMes(mes)}`].filter(item => item).length }} -->
            <!--
            <div
              v-for="(input, index) in placasInputs[`${corretor.id}-${strMes(mes)}`]"
              :key="index" 
            >
              <a 
                v-if="placasInputs[`${corretor.id}-${strMes(mes)}`][index] != ''" 
                :href="placasInputs[`${corretor.id}-${strMes(mes)}`][index]"
                :title="placasInputs[`${corretor.id}-${strMes(mes)}`][index]"
                :alt="placasInputs[`${corretor.id}-${strMes(mes)}`][index]"
                target="_blank" rel="noopener noreferrer"
                class="btn fs-6 "
              >
                Link #{{ index + 1 <= 9 ? "0" : "" }}{{ index + 1 }}
              </a>
            </div>
            -->
          </td>
        </tr>
      </tbody>
    </table>
    <!-- <h5 class="text-danger fw-bolder">Informe os códigos dos imóveis, separando-os por vírgula ","</h5>
    <sub class="text-info">É fácil, você consegue</sub> -->
    <!-- <br> -->
    <!-- <sub class="text-info">Acredite</sub> -->
    <!-- TABELA (não-admin) -->
    <table v-else class="table table-striped mt-5 w-full border-collapse border border-gray-300 bg-white md-table">
      <thead>
        <tr>
          <th class="border px-4 py-2 pb-3"><b>Corretor</b></th>
          <th
            v-for="i in monthIndices"
            :key="i"
            class="border px-4 py-2 pb-3"
          >
            <b>{{ abrevia(meses[i], 3) }}</b>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="corretor in filteredCorretores" :key="corretor.id" class="super-tr">
          <td class="border px-4 py-2">{{ corretor.nome }}</td>

          <td
            class="border px-2 py-2"
            v-for="i in monthIndices"
            :key="i"
          >
            <div>
              <input
                v-for="(input, index) in placasInputs[`${corretor.id}-${meses[i]}`] || Array(10).fill('')"
                :key="index"
                v-model="placasInputs[`${corretor.id}-${meses[i]}`][index]"
                class="form-control text-center my-1 ph-danger"
                :placeholder="'código #' + (index +1) +'º'"
              />
              <br>
              <button
                class="btn btn-success"
                @click="atualizarPlacas(corretor.id, meses[i], corretor.placas?.[String(i)])"
                :disabled="desabilitado[`${corretor.id}-${meses[i]}`]"
              >🗹</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { onMounted, computed, ref, reactive } from "vue";

const desabilitado = reactive({});
const useradmin = ref(false);

const meses = [
  "janeiro", "fevereiro", "março", "abril", "maio", "junho",
  "julho", "agosto", "setembro", "outubro",
  "novembro", "dezembro"
];

// const urlraiz = 'http://localhost:8080';
const urlraiz = 'https://www.avantorimoveis.com.br/dadoscorretor';

function strMes(mes) {
  // se já for string com nome do mês, retorna diretamente
  if (typeof mes === 'string' && isNaN(Number(mes))) return mes;
  return meses[mes];
}
function abrevia(value, length) {
  if (!value) return '';
  value = value.toString();
  if (value.length <= length) return value;
  return value.substring(0, length);
}

const corretores = ref([]);
const bloqueiacampo = ref(null);
const placasInputs = reactive({}); // Armazena os valores de cada campo dividido
// FILTROS reativos
const selectedCorretor = ref("");
const selectedMes = ref(""); // armazenará índice do mês como number ou "" para todos

// Computed: array de índices de mês a renderizar (0..11)
const monthIndices = computed(() => {
  if (selectedMes.value !== "" && selectedMes.value !== null) {
    const idx = Number(selectedMes.value);
    if (!isNaN(idx)) return [idx];
  }
  if(selectedMes.value === "1_trimestre") { return [0,1,2]; }
  if(selectedMes.value === "2_trimestre") { return [3,4,5]; }
  if(selectedMes.value === "3_trimestre") { return [6,7,8]; }
  if(selectedMes.value === "4_trimestre") { return [9,10,11]; }
  // todos os meses por padrão (0..11)
  return meses.map((m, i) => i);
});

// Computed: lista de corretores filtrada por selectedCorretor
const filteredCorretores = computed(() => {
  if (!selectedCorretor.value) return corretores.value;
  return corretores.value.filter(c => String(c.id) === String(selectedCorretor.value));
});

const atualizarPlacas = async (corretorId, mes, marketplace) => {
  console.log(`Atualizando placa do corretor ${corretorId} no mês ${mes} com valor ${marketplace}`);
  // Exemplo de chamada para a API do backend
  const placasString = getPlacasFormatadas(corretorId, mes).value;
  await fetch(`${urlraiz}/placas/atualizamp?corretorId=${corretorId}&mes=${mes}&marketplace=${placasString}`);
  // desabilitado[`${corretorId}-${mes}`] = true;
  alert("Link Adicionado com sucesso");
  window.location.reload();
};

const carregarDados = async () => {
  // Inicializa os registros no backend
  await fetch(urlraiz + "/placas/initialize/");

  let searchCorretor;
  if (localStorage.getItem("authUser")) {
    const dadoscorretor = localStorage.getItem("authUser");
    const corretor = JSON.parse(dadoscorretor);
    searchCorretor = corretor.id;
  }

  var corretoresadmin = false;

  if (searchCorretor == 1 || searchCorretor == 10 || searchCorretor == 73  || searchCorretor == 43  || searchCorretor == 91) {
    corretoresadmin = true;
  }

  // Carrega os dados dos corretores e placas
  var filtracorretor = '';
  if (corretoresadmin) {
    filtracorretor = '';
  } else {
    filtracorretor = "?corretor_id=" + searchCorretor;
  }
  const response = await fetch(urlraiz + "/placas" + filtracorretor);
  corretores.value = await response.json();
  corretores.value.forEach(corretor => {
    Object.entries(corretor.marketplace).forEach(([mes, valor]) => {
      placasInputs[`${corretor.id}-${strMes(mes)}`] = valor ? valor.split(',').concat(Array(30 - valor.split(',').length).fill("")) : Array(30).fill("");
      if (valor && valor != "") {
        for (let index = 0; index < valor.split(',').length; index++) {
          desabilitado[`${corretor.id}-${strMes(mes)}-${index}`] = true;
        }
      }
    });
  });
};
// Inicializa os inputs dividindo a string das placas por vírgula

// Computed para transformar os inputs em string separada por vírgulas antes de enviar
const getPlacasFormatadas = (corretorId, mes) => {
  return computed(() => placasInputs[`${corretorId}-${mes}`]?.filter(v => v.trim() !== "").join(',') || "");
};
function resetFiltros() {
  selectedCorretor.value = "";
  selectedMes.value = "";
}
// fecha
// onMounted();

onMounted(() => {
  let searchCorretor;
  if (localStorage.getItem("authUser")) {
    var dadoscorretor = localStorage.getItem("authUser");
    var corretor = JSON.parse(dadoscorretor);
    searchCorretor = corretor.id;
  }
  if (searchCorretor == 1 || searchCorretor == 10 || searchCorretor == 73  || searchCorretor == 43  || searchCorretor == 91) {
    useradmin.value = true;
  }
  carregarDados();
});

</script>
<style scoped>
.super-tr:hover {
  background-color: lightgray !important;
}
.input-destaque {
  border: 1px solid gray;
}
::placeholder {
  color: lightslategray; /* Change this to your desired color */
  opacity: 1; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: lightslategray;
}

::-ms-input-placeholder { /* Microsoft Edge */
  color: lightslategray;
}
</style>