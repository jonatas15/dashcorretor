<template>
  <div class="container mt-0 p-5 br-2 bg-white" style="border-top-right-radius: 90px">
    <h2>Sistema de Precificação de Imóveis</h2>
    <hr>
    <!-- Stepper de etapas -->
    <nav class="stepper mb-4 bg-transparent" aria-label="Progresso da precificação">
      <button
        v-for="step in steps"
        :key="step.number"
        type="button"
        class="step-item"
        :class="stepClass(step.number)"
        :disabled="isStepDisabled(step.number)"
        :aria-current="currentStep === step.number ? 'step' : undefined"
        @click="goToStep(step.number)"
      >
        <span class="step-circle">{{ step.number }}</span>
        <span class="step-label">{{ step.label }}</span>
      </button>
    </nav>
    <form @submit.prevent="handleFilter" id="formulario-precificacao" v-show="currentStep === 1">
      <div class="row">
        <div class="col-md-12">  
          <!-- <div class="p-0 mb-3 card">
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
          </div> -->
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
          <label class="form-label py-2" @click="toggleDiv">
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
        <button type="submit" class="btn btn-primary">Buscar Imóveis</button>
        <button type="button" class="btn btn-secondary" @click="resetForm">Limpar Campos</button>
      </div>
    </form>
    <div v-show="carregando && currentStep === 2">
      <img src="@/assets/actions/please-wait.gif" />
    </div>
    <h3 class="mt-5" v-show="!carregando && currentStep === 2">Resultados</h3>

    <label class="fs-12 fw-bolder" v-show="!carregando && currentStep === 2">({{ pagination.total }} imóveis)</label>
    <hr v-show="!carregando && currentStep === 2">
    <!-- {{ data[1] }} -->
    
    <!-- Modal de Mediana -->
    <Teleport to="body">
      <div v-if="showModalMediana" class="modal-backdrop-custom" @click.self="showModalMediana = false">
        <div class="modal-box-custom">
          <div class="modal-box-header">
            <h5 class="mb-0">Calcular Mediana</h5>
            <button type="button" class="btn-close" @click="showModalMediana = false"></button>
          </div>
          <div class="modal-box-body">
            <p class="text-danger small">
              A mediana foi calculada com os imóveis selecionados. Se nenhum estiver selecionado, o cálculo usa todos os imóveis exibidos.
            </p>
            <h6 v-if="form.bairro.length > 0" class="text-muted">{{ form.bairro.join(', ') }}</h6>
            <div v-if="mediana !== null" class="alert alert-info text-center">
              Mediana dos valores:<hr>
              <strong class="fs-3">R$ {{ Math.round(mediana).toLocaleString() }}</strong>
              <div class="mt-2 text-muted small">
                {{ selecionados.length > 0 ? selecionados.length + ' imóveis selecionados' : pagination.total + ' imóveis (todos)' }}
              </div>
            </div>
            <div v-if="mediana !== null" class="d-grid">
              <button class="btn btn-success" @click="currentStep = 3; showModalMediana = false">
                Gerar Relatório →
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>

    <div v-show="currentStep === 2">
      <!-- Barra de ações da etapa 2 -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <button type="button" class="btn btn-outline-secondary btn-sm" @click="currentStep = 1">← Voltar para Pesquisa</button>
        <div class="d-flex align-items-center gap-2">
          <span v-if="selecionados.length > 0" class="badge bg-info text-white">{{ selecionados.length }} selecionado(s)</span>
          <button class="btn btn-info text-white btn-sm" @click="openMedianaModal" :disabled="carregando || data.length === 0">
            Calcular Mediana
          </button>
        </div>
      </div>

      <!-- Resumo dos Filtros Aplicados -->
      <div v-show="!carregando" class="card mb-4 bg-light">
        <div class="card-body p-3">
          <h6 class="card-title mb-3 text-muted">Filtros Aplicados</h6>
          <div class="row g-2">
            <div class="col-md-2">
              <small class="text-muted d-block">Imobiliária</small>
              <strong>{{ form.imobiliaria || 'Todas' }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Cidade</small>
              <strong>{{ form.cidade || 'Todas' }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Bairros</small>
              <strong>{{ form.bairro.length > 0 ? form.bairro.join(', ') : 'Todos' }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Negócios</small>
              <strong>{{ form.negocio.length > 0 ? form.negocio.join(', ') : 'Todos' }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Valor (R$)</small>
              <strong>{{ formatRangeValor() }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Área (m²)</small>
              <strong>{{ formatRangeArea() }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Dormitórios</small>
              <strong>{{ form.dormitorios.length > 0 ? form.dormitorios.join(', ') : 'Todos' }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Banheiros</small>
              <strong>{{ form.banheiros.length > 0 ? form.banheiros.join(', ') : 'Todos' }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Garagens</small>
              <strong>{{ form.garagens.length > 0 ? form.garagens.join(', ') : 'Todos' }}</strong>
            </div>
            <div class="col-md-2">
              <small class="text-muted d-block">Mobiliado</small>
              <strong>{{ formatMobiliado() }}</strong>
            </div>
          </div>
        </div>
      </div>

      <div>
          <table class="table table-striped" v-show="!carregando && data.length > 0">
          <thead>
            <tr>
              <th>✅</th>
              <th @click="sortBy('imobiliaria')" style="cursor: pointer;">
                Imobiliária
                <font-awesome-icon v-if="sort.column === 'imobiliaria'" :icon="sort.direction === 'asc' ? 'arrow-up' : 'arrow-down'" />
              </th>
              <th @click="sortBy('bairro')" style="cursor: pointer;">
                Bairro
                <font-awesome-icon v-if="sort.column === 'bairro'" :icon="sort.direction === 'asc' ? 'arrow-up' : 'arrow-down'" />
              </th>
              <th @click="sortBy('negocio')" style="cursor: pointer;">
                Negócio
                <font-awesome-icon v-if="sort.column === 'negocio'" :icon="sort.direction === 'asc' ? 'arrow-up' : 'arrow-down'" />
              </th>
              <th @click="sortBy('valor')" style="cursor: pointer;">
                Valor
                <font-awesome-icon v-if="sort.column === 'valor'" :icon="sort.direction === 'asc' ? 'arrow-up' : 'arrow-down'" />
              </th>
              <th @click="sortBy('area')" style="cursor: pointer;">
                Área (m²)
                <font-awesome-icon v-if="sort.column === 'area'" :icon="sort.direction === 'asc' ? 'arrow-up' : 'arrow-down'" />
              </th>
              <th>Cômodos</th> <!-- Não ordenável, pois é composto. Veja considerações abaixo. -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in data" :key="index">
              <td>
                <input type="checkbox" :checked="item.url in selecionadosMap" @change="toggleSelecionado(item)" :id="'select-' + index">
              </td>
              <td><a :href="item.url" target="_blank"><font-awesome-icon icon="link"/> {{ item.imobiliaria ? item.imobiliaria : 'ver imóvel' }}</a></td>
              <!-- <td>{{ item.estado }}</td> -->
              <!-- <td>{{ item.cidade }}</td> -->
              <td>{{ item.bairro }}</td>
              <td>{{ item.negocio }}</td>
              <!-- <td>{{ item.finalidade == 'Locacao' ? 'Locação' : item.finalidade }}</td> -->
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
              <!-- <td v-if="item.mobiliado == 1" class="text-success">Mobiliado</td>
              <td v-else-if="item.mobiliado == 2" class="text-primary">Semi-mobiliado</td>
              <td v-else class="text-danger">Não mobiliado</td> -->
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <button class="btn btn-info" :disabled="pagination.page === 1" @click="changePage(pagination.page - 1)">
            Anterior
          </button>
          <span>Página {{ pagination.page }} de {{ totalPages }}</span>
          <button class="btn btn-info" :disabled="pagination.page === totalPages" @click="changePage(pagination.page + 1)">
            Próxima
          </button>
        </div>
      </div>
    </div>
    <div v-if="currentStep === 3">
      <button type="button" class="btn btn-outline-secondary btn-sm mb-3" @click="currentStep = 2">← Voltar para Resultados</button>
      <relatorio 
        :mediana="mediana !== null ? mediana : 0" 
        :imoveis="selecionados.length > 0 ? selecionados : data" 
        :bairros="form.bairro"
        :cidade="form.cidade"
        :fotocorretor="fotocorretor"
      ></relatorio>
    </div>
  </div>
  
</template>

<script setup>
import { ref, reactive, computed, onMounted, onBeforeUnmount, defineProps } from 'vue';
import {Money} from 'v-money';
import { API_URL } from "@/config/api";
// Vamos criar uma modal para exportrar o relatório
// import Modal from '@/components/Modal.vue';
import Relatorio from './Relatorio.vue';

// import RangeSlider from 'vue-range-slider'
// you probably need to import built-in style
// import 'vue-range-slider/dist/vue-range-slider.css'
// import VueThousandSeparator from 'vue-thousand-separator';

const currentStep = ref(1); // 1: Pesquisa | 2: Resultados/Mediana | 3: Relatório
const showModalMediana = ref(false);
const medianaCalculada = ref(false);

const steps = [
  { number: 1, label: 'Pesquisa' },
  { number: 2, label: 'Resultados' },
  { number: 3, label: 'Relatório' },
];

const props = defineProps({
  fotocorretor: String
});
const fotocorretor = ref(props.fotocorretor || "");

console.log(fotocorretor.value)

const initialForm = {
  imobiliaria: '',
  estado: '',
  cidade: '',
  bairro: ref([]),
  negocio: ref([]),
  finalidade: 'Venda',
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
// const urlraiz = 'http://localhost:8080';
const urlraiz = API_URL.baseUrl;

const range = ref([-5, 5]);

const pagination = reactive({
  page: 1,
  pageSize: 100,
  total: 0,
});

const selecionadosMap = ref({});
const selecionados = computed(() => Object.values(selecionadosMap.value));
const toggleSelecionado = (item) => {
  const key = item.url;
  if (key in selecionadosMap.value) {
    const updated = { ...selecionadosMap.value };
    delete updated[key];
    selecionadosMap.value = updated;
  } else {
    selecionadosMap.value = { ...selecionadosMap.value, [key]: item };
  }
};
const mediana = ref(null);

const parseValor = (val) => {
  if (typeof val === 'number') return val;
  if (typeof val !== 'string') return NaN;
  const cleaned = val.replace(/\./g, '').replace(/,/g, '.');
  return parseFloat(cleaned);
};

const sort = ref({
  column: '', // Coluna atual (ex: 'valor')
  direction: 'asc' // 'asc' ou 'desc'
});

const stepClass = (stepNumber) => {
  if (isStepDisabled(stepNumber)) return 'is-locked';
  if (stepNumber < currentStep.value) return 'is-done';
  if (stepNumber === currentStep.value) return 'is-active';
  return 'is-pending';
};

const isStepDisabled = (stepNumber) => {
  if (stepNumber === 1) return false;
  if (stepNumber === 2) return !(data.value.length > 0 || pagination.total > 0);
  if (stepNumber === 3) return !medianaCalculada.value;
  return false;
};

const goToStep = (stepNumber) => {
  if (isStepDisabled(stepNumber)) return;

  if (stepNumber === 1) {
    currentStep.value = 1;
    return;
  }

  if (stepNumber === 2 && (data.value.length > 0 || pagination.total > 0)) {
    currentStep.value = 2;
    return;
  }

  if (stepNumber === 3 && (data.value.length > 0 || selecionados.value.length > 0)) {
    currentStep.value = 3;
  }
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
    `&paginafonte=precificacao` +
    `&sort_by=${sort.value.column}` +  // Novo parâmetro
    `&sort_dir=${sort.value.direction}`  // Novo parâmetro
  );
  const result = await response.json();
  // console.log(result)
  // lista de imobiliárias --------------------------------
  const imobs = await fetch(`${urlraiz}/imoveisex/getimobiliarias`);
  const imobsresult = await imobs.json();
  imobiliarias.value = imobsresult.data;
  // lista de cidades --------------------------------
  const cities = await fetch(`${urlraiz}/imoveisex/getcidades?paginafonte=precificacao`);
  const citiesresult = await cities.json();
  cidades.value = citiesresult.data;
  // lista de bairros --------------------------------
  const bairrosx = await fetch(`${urlraiz}/imoveisex/getbairros?paginafonte=precificacao`);
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

const sortBy = (column) => {
  if (sort.value.column === column) {
    // Alterna direção se for a mesma coluna
    sort.value.direction = sort.value.direction === 'asc' ? 'desc' : 'asc';
  } else {
    // Muda coluna e reseta para asc
    sort.value.column = column;
    sort.value.direction = 'asc';
  }
  pagination.page = 1; // Reseta para página 1 ao ordenar
  medianaCalculada.value = false;
  fetchData(); // Recarrega dados com nova ordenação
};

// Atualizar a tabela com filtros
const handleFilter = () => {
  pagination.page = 1;
  selecionadosMap.value = {};
  mediana.value = null;
  medianaCalculada.value = false;
  sort.value.column = '';
  sort.value.direction = 'asc';
  fetchData();
  currentStep.value = 2;
};

const changePage = (newPage) => {
  pagination.page = newPage;
  medianaCalculada.value = false;
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
  selecionadosMap.value = {}; // Limpar selecionados ao resetar o formulário
  mediana.value = null; // Resetar mediana
  medianaCalculada.value = false;
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
    medianaCalculada.value = true;
    return;
  }

  valores = valores.sort((a, b) => a - b);
  const meio = Math.floor(valores.length / 2);

  if (valores.length % 2 === 0) {
    mediana.value = ((valores[meio - 1] + valores[meio]) / 2) / 100;
  } else {
    mediana.value = (valores[meio])/100;
  }
  medianaCalculada.value = true;
};

const openMedianaModal = () => {
  calculateMedian();
  showModalMediana.value = true;
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

// Formatadores para os resumos de filtros
const formatRangeValor = () => {
  // Limpa e converte valores formatados pela diretiva v-money
  const parseMoneyValue = (val) => {
    if (!val) return null;
    const cleaned = String(val).replace(/\./g, '').replace(',', '.');
    return parseFloat(cleaned);
  };
  
  const minVal = parseMoneyValue(form.valormin);
  const maxVal = parseMoneyValue(form.valormax);
  
  if (!minVal && !maxVal) return 'Todos';
  
  const formatCurrency = (num) => `R$ ${Math.round(num).toLocaleString('pt-BR')}`;
  
  if (minVal && maxVal) return `${formatCurrency(minVal)} - ${formatCurrency(maxVal)}`;
  if (minVal) return `a partir de ${formatCurrency(minVal)}`;
  if (maxVal) return `até ${formatCurrency(maxVal)}`;
  return 'Todos';
};

const formatRangeArea = () => {
  const min = form.areamin ? `${form.areamin} m²` : 'Sem mín.';
  const max = form.areamax ? `${form.areamax} m²` : 'Sem máx.';
  if (!form.areamin && !form.areamax) return 'Todos';
  if (!form.areamin) return `até ${max}`;
  if (!form.areamax) return `a partir de ${min}`;
  return `${min} - ${max}`;
};

const formatMobiliado = () => {
  const mobileMap = {
    '0': 'Não mobiliado',
    '1': 'Mobiliado',
    '2': 'Semi-mobiliado',
    '3': 'Tanto faz'
  };
  return mobileMap[form.mobiliado] || 'Todos';
};

const reduz_ns = (palavra) => {
  var retorno = '';
  retorno = palavra.replace(/Nossa Senhora/g, 'Nsaª').replace(/Santa Maria/g, 'SM');
  return retorno;
}

// Função para reiniciar ou recarregar a página toda
const recarregarPagina = () => {
  window.location.reload();
};

//------------------------------------------------------------------------------------------------ 2026 - Ordenamento


onMounted(() => {
  fetchData();
  document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<style>
.stepper {
  --step-neutral: #d8dde3;
  --step-neutral-text: #7e8b97;
  --step-active: #2f95dc;
  --step-done: #30c56b;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  align-items: flex-start;
  width: 100%;
}

.step-item {
  position: relative;
  background: transparent;
  border: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  width: 100%;
  color: var(--step-neutral-text);
  cursor: pointer;
  padding: 0;
}

.step-item::after {
  content: '';
  position: absolute;
  top: 16px;
  left: 50%;
  width: 100%;
  height: 4px;
  border-radius: 999px;
  background: transparent;
}

.step-item:last-child::after {
  display: none;
}

.step-circle {
  width: 34px;
  height: 34px;
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  font-weight: 700;
  line-height: 1;
  color: #fff;
  background: var(--step-neutral);
  border: 2px solid var(--step-neutral);
  z-index: 2;
  transition: transform 0.18s ease, box-shadow 0.18s ease;
}

.step-label {
  font-size: 0.92rem;
  font-weight: 600;
  text-align: center;
}

.step-item.is-done .step-circle {
  background: var(--step-done);
  border-color: var(--step-done);
  color: #fff;
}

.step-item.is-done .step-label {
  color: var(--step-done);
}

.step-item.is-done::after {
  background: var(--step-done);
}

.step-item.is-active .step-circle {
  background: var(--step-active);
  border-color: var(--step-active);
  color: #fff;
  box-shadow: none;
}

.step-item.is-active .step-label {
  color: var(--step-active);
}

.step-item.is-pending .step-circle {
  color: #fff;
}

.step-item.is-locked .step-circle {
  background: #e3e8ed;
  border-color: #e3e8ed;
  color: #fff;
}

.step-item.is-locked {
  cursor: not-allowed;
  opacity: 0.72;
}

.step-item:disabled {
  pointer-events: none;
}

.step-item:hover .step-circle {
  transform: translateY(-1px);
}

@media (max-width: 767.98px) {
  .step-circle {
    width: 30px;
    height: 30px;
    font-size: 0.86rem;
  }

  .step-label {
    font-size: 0.8rem;
  }

  .step-item::after {
    top: 14px;
    height: 3px;
  }
}

/* Modal customizada - Mediana */
.modal-backdrop-custom {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  z-index: 1050;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-box-custom {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  width: 100%;
  max-width: 440px;
  overflow: hidden;
}

.modal-box-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.25rem;
  border-bottom: 1px solid #dee2e6;
  background: #f8f9fa;
}

.modal-box-body {
  padding: 1.25rem;
}

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