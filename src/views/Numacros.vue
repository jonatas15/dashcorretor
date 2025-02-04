<template>
  <div class="bg-white pt-5 w-full" style="border-top-right-radius: 90px">
    <h4><strong>Placas</strong></h4>
    <!-- <h5 class="text-danger fw-bolder">Informe os códigos dos imóveis, separando-os por vírgula ","</h5>
    <sub class="text-info">É fácil, você consegue</sub> -->
    <!-- <br> -->
    <!-- <sub class="text-info">Acredite</sub> -->
    <table class="table table-striped mt-5 w-full border-collapse border border-gray-300 bg-white md-table">
      <thead>
        <tr>
          <th class="border px-4 py-2 pb-3"><b>Corretor</b></th>
          <th class="border px-4 py-2 pb-3" v-for="mes in meses" :key="mes"><b>{{ abrevia(mes, 3) }}</b></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="corretor in corretores" :key="corretor.id" class="super-tr">
          <td class="border px-4 py-2">{{ corretor.nome }}</td>
          <td
            class="border px-2 py-2"
            v-for="(valor, mes) in corretor.placas"
            :key="mes"
          >
              
            <div v-if="desabilitado[`${corretor.id}-${strMes(mes)}`]">
              <p v-if="formatarImoveis(corretor.placas[mes])" v-html="formatarImoveis(corretor.placas[mes])" align="left"></p>
              <p v-else v-html="placasInputs[`${corretor.id}-${strMes(mes)}`].join('<br>')">
              </p>
            </div>
            <div v-else>
              <!-- <textarea
                :class="'w-full text-center form-control ' + (corretor.placas[mes] >= 1 ? 'input-destaque' : '')"
                v-model="corretor.placas[mes]"
                rows="6"
                :disabled="desabilitado[`${corretor.id}-${strMes(mes)}`] || false"
                >
              </textarea> -->
              <!-- {{ placasInputs }} -->
              <input
                v-for="(input, index) in placasInputs[`${corretor.id}-${strMes(mes)}`]"
                :key="index"
                v-model="placasInputs[`${corretor.id}-${strMes(mes)}`][index]"
                class="form-control text-center my-1 ph-danger"
                :disabled="desabilitado[`${corretor.id}-${strMes(mes)}`] || false"
                :placeholder="'código #' + (index +1) +'º'"
              />
                <!-- @change="atualizarPlacas(corretor.id, strMes(mes), corretor.placas[mes])" -->
                <br>
                <button 
                  class="btn btn-success"
                  @click="atualizarPlacas(corretor.id, strMes(mes), corretor.placas[mes])"
                  :disabled="desabilitado[`${corretor.id}-${strMes(mes)}`]"
                >🗹</button>
              <!-- <label v-else>{{ corretor.placas[mes] }}</label> -->
              <!-- {{ strMes(mes) }} -->
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

const formatarImoveis = (lista) => {
  // console.log(lista)
  if (lista != "") {
    return lista.split(',').join('<br>'); // Quebra na vírgula e adiciona `<br>`
  }
};

const meses = [
  "janeiro", "fevereiro", "março", "abril", "maio", "junho",
  // "julho", "agosto", "setembro", "outubro",
  // "novembro", "dezembro"
];

// const urlraiz = 'http://localhost:8080';
const urlraiz = 'https://www.cafeimobiliaria.com.br/dadoscorretor';

function strMes(mes) {
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


const atualizarPlacas = async (corretorId, mes, quantidade) => {
  console.log(`Atualizando placa do corretor ${corretorId} no mês ${mes} com valor ${quantidade}`);
  // Exemplo de chamada para a API do backend
  const placasString = getPlacasFormatadas(corretorId, mes).value;
  await fetch(`${urlraiz}/placas/atualiza?corretorId=${corretorId}&mes=${mes}&quantidade=${placasString}`);
  desabilitado[`${corretorId}-${mes}`] = true;
};
const carregarDados = async () => {
  // Inicializa os registros no backend
  await fetch(urlraiz + "/placas/initialize/");

  if (localStorage.getItem("authUser")) {
    var dadoscorretor = localStorage.getItem("authUser");
    var corretor = JSON.parse(dadoscorretor);
    var searchCorretor = corretor.id;
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
    Object.entries(corretor.placas).forEach(([mes, valor]) => {
      placasInputs[`${corretor.id}-${strMes(mes)}`] = valor ? valor.split(',') : Array(10).fill("");
      if (valor && valor != "") {
        desabilitado[`${corretor.id}-${strMes(mes)}`] = true;
        // console.log(`${valor} = ${strMes(mes)}`)
      }
    });
  });
};
// Inicializa os inputs dividindo a string das placas por vírgula

// Computed para transformar os inputs em string separada por vírgulas antes de enviar
const getPlacasFormatadas = (corretorId, mes) => {
  return computed(() => placasInputs[`${corretorId}-${mes}`]?.filter(v => v.trim() !== "").join(',') || "");
};
// fecha
onMounted(carregarDados);

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