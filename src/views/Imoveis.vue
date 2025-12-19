<template>
  <div class="container mt-0 p-5 br-2 bg-white" style="border-top-right-radius: 90px">
    <h2>Pesquisar Imóveis externos</h2>
    <hr>
    <form @submit.prevent="handleFilter" id="formulario_imoveis">
      <div class="row">
        <div class="col-md-12">  
          <div class="p-0 mb-3 card">
            <div class="card-header">Finalidade/Tipo</div>
            <div class="card-body align-center align-middle d-flex justify-content-center">
              <div class="toggle-wrapper-3">
                <input type="radio" id="opt-todos" :value="''" v-model="form.finalidade">
                <label for="opt-todos" class="text-bolder fs-6 fw-bolder">Todos</label>

                <input type="radio" id="opt-venda" value="Venda" v-model="form.finalidade">
                <label for="opt-venda" class="text-bolder fs-6 fw-bolder">Venda</label>

                <input type="radio" id="opt-locacao" value="Locacao" v-model="form.finalidade">
                <label for="opt-locacao" class="text-bolder fs-6 fw-bolder">Locação</label>
                <span class="switch-bg-3"></span>
              </div>
            </div>
          </div>
        </div>
        <!-- Imobiliária -->
        <div class="col-md-6 mb-3">
          <label for="imobiliaria" class="form-label">Imobiliária</label>
          <select v-model="form.imobiliaria" id="imobiliaria" class="form-select">
            <option value="">Todas</option>
            <option v-for="imb in imobiliarias" :value="imb.imobiliaria" :key="imb.imobiliaria">{{imb.imobiliaria}}</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="cidade" class="form-label">Cidade</label>
          <select v-model="form.cidade" id="cidade" class="form-select">
            <option value="">Todas</option>
            <option v-for="imb in cidades" :value="imb.cidade" :key="imb.cidade">{{imb.cidade}}</option>
          </select>
        </div>
        <!-- Bairro -->
        <div class="col-md-12 mb-3">
          <div class="card p-1 bairros_listados">
          <label for="bairro" class="form-label py-2" @click="toggleDiv">
            Bairros: {{ form.bairro.length > 0 ?  form.bairro + " | ⏷" : 'Selecione 1/mais bairros ⏷' }}
          </label>
          <div class="row mx-2" v-show="verBairros" @click.self="hideDiv">
              <hr>
              <div class="col-md-4" style="text-align: left;" v-for="(opcao, index) in bairros" :key="index">
                <input type="checkbox" :value="opcao.bairro" v-model="form.bairro" :id="'bairro-' + index">
                <label :for="'bairro-' + index"><span>&ensp;</span>{{ reduz_ns(opcao.bairro) }}</label>
              </div>
            </div>
          </div>
        </div>
        <!-- Valor -->
        <div class="col-md-3 mb-3">
          <label for="valor" class="form-label">Valor Mínimo (R$)</label>
          <!-- @change="alteraomax" -->
          <input v-money="Money" v-model="form.valormin" type="text" id="valormin" class="form-control" />
        </div>
        <div class="col-md-3 mb-3">
          <label for="valormax" class="form-label">Valor Máximo (R$)</label>
          <input v-money="Money" v-model="form.valormax" type="text" id="valormax" class="form-control" />
        </div>
        <!-- Área -->
        <div class="col-md-3 mb-3">
          <label for="areamin" class="form-label">Área Mínima (m²)</label>
          <input v-model="form.areamin" type="number" id="areamin" class="form-control" />
        </div>
        <div class="col-md-3 mb-3">
          <label for="areamax" class="form-label">Área Máxima (m²)</label>
          <input v-model="form.areamax" type="number" id="areamax" class="form-control" />
        </div>
        <!-- Negócio -->
        <div class="col-md-12 mb-3">
          <div class="card p-1 negocios_listados">
          <label for="negocio" class="form-label py-2" @click="toggleDiv2">
            Negócios: {{ form.negocio.length > 0 ?  form.negocio + " | ⏷" : 'Selecione 1/mais negócios ⏷' }}
          </label>
          <div class="row mx-2" v-show="verNegocios" @click.self="hideDiv2">
              <hr>
              <div class="col-md-4" style="text-align: left;" v-for="(opcao, index) in negocios" :key="index">
                <input type="checkbox" :value="opcao.negocio" v-model="form.negocio" :id="'negocio-' + index">
                <label :for="'negocio-' + index"><span>&ensp;</span>{{ opcao.negocio }}</label>
              </div>
            </div>
          </div>
        </div>
        <!-- Dormitórios -->
        <div class="col-md-3 mb-3">
          <label for="dormitorios" class="form-label">Dormitórios</label>
          <!-- <input v-model="form.dormitorios" type="number" id="dormitorios" class="form-control" /> -->
          <!-- <select class="form-select" v-model="form.dormitorios" id="dormitorios">
            <option value="0">Selecione</option>
            <option value="1">1+</option>
            <option value="2">2+</option>
            <option value="3">3+</option>
            <option value="4">4+</option>
          </select> -->
          <div class="card px-1 py-0">
            <div class="row">
              <div class="col mt-0 pt-2 pb-0 mb-0" style="text-align: left;" v-for="(opcao, index) in dormitorios" :key="index">
                <input type="checkbox" :value="opcao" v-model="form.dormitorios" :id="'dormitorio-' + index">
                <label :for="'dormitorio-' + index"><span>&ensp;</span>{{ opcao }}</label>
              </div>
            </div>
          </div>
        </div>
        <!-- Banheiros -->
        <div class="col-md-3 mb-3">
          <label for="banheiros" class="form-label">Banheiros</label>
          <div class="card px-1 py-0">
            <div class="row">
              <div class="col mt-0 m-0 mx-0 pt-2 pb-0 mb-0" style="text-align: left;" v-for="(opcao, index) in banheiros" :key="index">
                <input type="checkbox" :value="opcao" v-model="form.banheiros" :id="'banheiro-' + index">
                <label :for="'banheiro-' + index"><span>&ensp;</span>{{ opcao }}</label>
              </div>
            </div>
          </div>
        </div>
        <!-- Garagens -->
        <div class="col-md-3 mb-3">
          <label for="garagens" class="form-label">Garagens</label>
          <div class="card px-1 py-0">
            <div class="row">
              <div class="col mt-0 m-0 mx-0 pt-2 pb-0 mb-0" style="text-align: left;" v-for="(opcao, index) in garagens" :key="index">
                <input type="checkbox" :value="opcao" v-model="form.garagens" :id="'garagem-' + index">
                <label :for="'garagem-' + index"><span>&ensp;</span>{{ opcao }}</label>
              </div>
            </div>
          </div>
        </div>
        <!-- Salas -->
        <!-- <div class="col-md-2 mb-3">
          <label for="salas" class="form-label">Salas</label>
          <input v-model="form.salas" type="number" id="salas" class="form-control" />
        </div> -->
        <!-- Mobiliado -->
        <div class="col-md-3 mb-3">
          <label for="mobiliado" class="form-label">Mobiliado</label>
          <select v-model="form.mobiliado" id="mobiliado" class="form-select">
            <option value="3">Tanto faz</option>
            <option value="2">Semi-mobiliado</option>
            <option value="1">Mobiliado</option>
            <option value="0">Não mobiliado</option>
          </select>
        </div>
        <!-- <div class="col-md-2 mb-3">
          <button type="button" class="btn btn-secondary" @click="resetForm">Limpar Campos</button>
          <button type="submit" class="btn btn-primary form-control">Filtrar</button>
        </div> -->
      </div>
      <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <button type="button" class="btn btn-secondary" @click="resetForm">Limpar Campos</button>
      </div>
    </form>
    <div v-show="carregando">
      <img src="@/assets/actions/please-wait.gif" />
    </div>
    <h3 class="mt-5" v-show="!carregando">Resultados</h3>
    
    <label class="fs-12 fw-bolder" v-show="!carregando">({{ pagination.total }} imóveis)</label>
    <div class="row">
      <!-- Botão para recarregar a página: -->
      <button class="btn btn-warning mb-3 w-25" @click="recarregarPagina" v-show="!carregando">
        Recomeçar tudo
      </button>
    </div>
    <hr v-show="!carregando">
    <div class="row" v-show="!carregando">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">{{ Math.round(pagination.total).toLocaleString() }}</div>
          <div class="card-footer">Total</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">{{ Math.round(totalvendas).toLocaleString() }}</div>
          <div class="card-footer">Total em Vendas</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">{{ Math.round(totalalugas).toLocaleString() }}</div>
          <div class="card-footer">Total em Locações</div>
        </div>
      </div>
    </div>
    <hr v-show="!carregando">
    <!-- {{ data[1] }} -->
    <div class="row my-3">
      <hr>
    </div>
    <div class="row my-3">
      <hr>
    </div>
    <table class="table table-striped" v-show="!carregando && data.length > 0 && visualiza_relatorio == false">
      <thead>
        <tr>
          <th v-if="mediana !== null">Selecionar</th>
          <th>Imobiliária</th>
          <!-- <th>Estado</th> -->
          <th>Cidade</th>
          <th>Bairro</th>
          <th>Negócio</th>
          <th>Finalidade</th>
          <th>Valor</th>
          <th>Área (m²)</th>
          <th>Cômodos</th>
          <!-- <th>Banheiros</th>
          <th>Dormitórios</th>
          <th>Garagens</th> -->
          <!-- <th>Salas</th> -->
          <th>Mobiliado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td v-if="mediana !== null">
            <input type="checkbox" v-model="selecionados" :value="item" :id="'select-' + index">
          </td>
          <td><a :href="item.url" target="_blank"><font-awesome-icon icon="link"/> {{ item.imobiliaria ? item.imobiliaria : 'ver imóvel' }}</a></td>
          <!-- <td>{{ item.estado }}</td> -->
          <td>{{ item.cidade }}</td>
          <td>{{ item.bairro }}</td>
          <td>{{ item.negocio }}</td>
          <td>{{ item.finalidade == 'Locacao' ? 'Locação' : item.finalidade }}</td>
          <td>R$ {{ Math.round(item.valor).toLocaleString() }}</td>
          <td>{{ Math.round(item.area).toLocaleString() }}</td>
          <!-- <td>{{ item.banheiros }}</td>
          <td>{{ item.dormitorios }}</td>
          <td>{{ item.garagens }}</td> -->
          <!-- <td>{{ item.salas }}</td> -->
          <td>
            <div class="row">

              <span class="col m-0 p-0" v-if="item.dormitorios"><font-awesome-icon icon="bed"/> {{ item.dormitorios }}</span>
              <span class="col m-0 p-0" v-if="item.banheiros"><font-awesome-icon icon="shower"/> {{ item.banheiros }}</span>
              <span class="col m-0 p-0" v-if="item.garagens"><font-awesome-icon icon="car"/> {{ item.garagens }}</span>
            </div>
          </td>
          <td v-if="item.mobiliado == 1" class="text-success">Mobiliado</td>
          <td v-else-if="item.mobiliado == 2" class="text-primary">Semi-mobiliado</td>
          <td v-else class="text-danger">Não mobiliado</td>
        </tr>
      </tbody>
    </table>
    <!-- <button v-if="data.length < pagination.total" @click="loadMore">
      Carregar Mais
    </button> -->
    <!-- Paginação -->
    <div class="pagination" v-show="!carregando && visualiza_relatorio == false">
      <button class="btn btn-info" :disabled="pagination.page === 1" @click="changePage(pagination.page - 1)">
        Anterior
      </button>
      <span>Página {{ pagination.page }} de {{ totalPages }}</span>
      <button class="btn btn-info" :disabled="pagination.page === totalPages" @click="changePage(pagination.page + 1)">
        Próxima
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onBeforeUnmount } from 'vue';
import {Money} from 'v-money';
// Vamos criar uma modal para exportrar o relatório
// import Modal from '@/components/Modal.vue';

// import RangeSlider from 'vue-range-slider'
// you probably need to import built-in style
// import 'vue-range-slider/dist/vue-range-slider.css'
// import VueThousandSeparator from 'vue-thousand-separator';

const visualiza_relatorio = ref(false);


const initialForm = {
  imobiliaria: '',
  estado: '',
  cidade: '',
  bairro: ref([]),
  negocio: ref([]),
  finalidade: '',
  valormax: 0,
  valormin: 0,
  areamax: 0,
  areamin: 0,
  dormitorios: ref([]),
  garagens: ref([]),
  banheiros: ref([]),
  mobiliado: 3,
};

const form = reactive({ ...initialForm });

const carregando = ref(false);
const verNegocios = ref(false);
const verBairros = ref(false);

const data = ref([]);
const totalvendas = ref();
const totalalugas = ref();
const imobiliarias = ref([]);
const cidades = ref([]);
const bairros = ref([]);
const negocios = ref([]);
const dormitorios = ref(["1", "2", "3", "4+"]);
const garagens = ref(["1", "2", "3", "4+"]);
const banheiros = ref(["1", "2", "3", "4+"]);
const finalidades = ref([]);
const urlraiz = 'http://localhost:8080';
// const urlraiz = 'https://www.avantorimoveis.com.br/dadoscorretor';

const range = ref([-5, 5]);

const pagination = reactive({
  page: 1,
  pageSize: 100,
  total: 0,
});

const selecionados = ref([]);
const mediana = ref(null);

const parseValor = (val) => {
  if (typeof val === 'number') return val;
  if (typeof val !== 'string') return NaN;
  const cleaned = val.replace(/\./g, '').replace(/,/g, '.');
  return parseFloat(cleaned);
};

const fetchData = async () => {
  carregando.value = true;
  const response = await fetch(`${urlraiz}/imoveisex/getimoveis?page=${pagination.page}` +
    `&pageSize=${pagination.pageSize}` +
    `&imobiliaria=${form.imobiliaria}` +
    `&estado=${form.estado}` +
    `&cidade=${form.cidade}` +
    `&bairro=${form.bairro}` +
    `&negocio=${form.negocio}` +
    `&finalidade=${form.finalidade}` +
    `&valormin=${form.valormin}` +
    `&valormax=${form.valormax}` +
    `&areamin=${form.areamin}` +
    `&areamax=${form.areamax}` +
    `&dormitorios=${form.dormitorios}` +
    `&banheiros=${form.banheiros}` +
    `&garagens=${form.garagens}` +
    `&mobiliado=${form.mobiliado}` +
  ``);
  const result = await response.json();
  // console.log(result)
  // lista de imobiliárias --------------------------------
  const imobs = await fetch(`${urlraiz}/imoveisex/getimobiliarias`);
  const imobsresult = await imobs.json();
  imobiliarias.value = imobsresult.data;
  // lista de cidades --------------------------------
  const cities = await fetch(`${urlraiz}/imoveisex/getcidades`);
  const citiesresult = await cities.json();
  cidades.value = citiesresult.data;
  // lista de bairros --------------------------------
  const bairrosx = await fetch(`${urlraiz}/imoveisex/getbairros`);
  const bairrosxresult = await bairrosx.json();
  bairros.value = bairrosxresult.data;
  // lista de negocios --------------------------------
  const negociosx = await fetch(`${urlraiz}/imoveisex/getnegocios`);
  const negociosxresult = await negociosx.json();
  negocios.value = negociosxresult.data;
  // lista de finalidades --------------------------------
  const finalidadesx = await fetch(`${urlraiz}/imoveisex/getfinalidades`);
  const finalidadesxresult = await finalidadesx.json();
  finalidades.value = finalidadesxresult.data;

  data.value = result.data;
  totalvendas.value = result.totalvendas;
  totalalugas.value = result.totalalugas;
  // console.log(result);
  pagination.total = result.pagination.total;
  carregando.value = false;
};



// Atualizar a tabela com filtros
const handleFilter = () => {
  pagination.page = 1; // Resetar para a primeira página
  selecionados.value = []; // Limpar selecionados ao filtrar
  mediana.value = null; // Resetar mediana
  fetchData();
};

const changePage = (newPage) => {
  pagination.page = newPage;
  selecionados.value = []; // Limpar selecionados ao mudar página
  mediana.value = null; // Resetar mediana
  fetchData();
};
// const alteraomax = () => {
//   // console.log('chamou a function');
//   if (form.valormax < form.valormin) {
//     form.valormax = form.valormin + 1;
//   }
//   fetchData();
// };

const totalPages = computed(() => Math.ceil(pagination.total / pagination.pageSize));


// Carregar mais páginas
// const loadMore = () => {
//   if (data.value.length < pagination.total) {
//     pagination.page += 1;
//     fetchData();
//   }
// };
// Reseta o formulário para o estado inicial
const resetForm = () => {
  Object.keys(initialForm).forEach(key => {
    form[key] = Array.isArray(initialForm[key]) ? [] : initialForm[key];
    // limpa os campos marcados com check
    if (Array.isArray(form[key])) { form[key] = []; }
  });
  // limpa também os campos checked
  selecionados.value = []; // Limpar selecionados ao resetar o formulário
  mediana.value = null; // Resetar mediana
  pagination.page = 1; // Resetar para a primeira página
  fetchData();
};

const calculateMedian = () => {
  // Ativa o componente Relatório com os imóveis selecionados ou todos os imóveis
  // visualiza_relatorio.value = true;

  let rawValores = selecionados.value.length > 0 
    ? selecionados.value.map(item => item.valor) 
    : data.value.map(item => item.valor);

  let valores = rawValores
    .map(parseValor)
    .filter(v => !isNaN(v));

  if (valores.length === 0) {
    mediana.value = 0;
    return;
  }

  valores = valores.sort((a, b) => a - b);
  const meio = Math.floor(valores.length / 2);

  if (valores.length % 2 === 0) {
    mediana.value = ((valores[meio - 1] + valores[meio]) / 2) / 100;
  } else {
    mediana.value = (valores[meio])/100;
  }
};

const handleClickOutside = (event) => {
  if (verBairros.value && !event.target.closest('.bairros_listados')) {
    hideDiv();
  }
  if (verNegocios.value && !event.target.closest('.negocios_listados')) {
    hideDiv2();
  }
};
const toggleDiv = () => { verBairros.value = !verBairros.value; };
const hideDiv = () => { verBairros.value = false; };
const toggleDiv2 = () => { verNegocios.value = !verNegocios.value; };
const hideDiv2 = () => { verNegocios.value = false; };

const reduz_ns = (palavra) => {
  var retorno = '';
  retorno = palavra.replace(/Nossa Senhora/g, 'Nsaª').replace(/Santa Maria/g, 'SM');
  return retorno;
}

// Função para reiniciar ou recarregar a página toda
const recarregarPagina = () => {
  window.location.reload();
};

onMounted(() => {
  fetchData();
  document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<style>
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-top: 20px;
}

.pagination button {
  padding: 5px 10px;
  cursor: pointer;
}

.pagination button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}
.toggle-wrapper-3 {
  position: relative;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  width: 300px;
  background: #e9ecef;
  border-radius: 30px;
  padding: 5px;
  text-align: center;
  user-select: none;
}

.toggle-wrapper-3 input {
  display: none;
}

.toggle-wrapper-3 label {
  z-index: 2;
  padding: 6px 0;
  font-weight: 500;
  cursor: pointer;
  color: #000;
}

.switch-bg-3 {
  position: absolute;
  top: 5px;
  left: 5px;
  width: calc(33.33% - 5px);
  height: calc(100% - 10px);
  background: #0d6efd;
  border-radius: 30px;
  transition: 0.3s;
  z-index: 1;
}

/* --- POSIÇÃO DO SWITCH --- */
#opt-todos:checked ~ .switch-bg-3 {
  transform: translateX(0);
}

#opt-venda:checked ~ .switch-bg-3 {
  transform: translateX(100%);
}

#opt-locacao:checked ~ .switch-bg-3 {
  transform: translateX(200%);
}

/* --- COR DO TEXTO SELECIONADO --- */
#opt-todos:checked + label,
#opt-venda:checked + label,
#opt-locacao:checked + label {
  color: #fff !important;
}
</style>