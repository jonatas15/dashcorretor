<template>
  <div class="container mt-5">
    <h2>Formulário de Pesquisa</h2>
    <form @submit.prevent="handleFilter">
      <div class="row">
        <!-- Imobiliária -->
        <div class="col-md-3 mb-3">
          <label for="imobiliaria" class="form-label">Imobiliária</label>
          <select v-model="form.imobiliaria" id="imobiliaria" class="form-select">
            <option value="">Todas</option>
            <option v-for="imb in imobiliarias" :value="imb.imobiliaria" :key="imb.imobiliaria">{{imb.imobiliaria}}</option>
          </select>
        </div>
        <!-- Estado -->
        <!-- <div class="col-md-3 mb-3">
          <label for="estado" class="form-label">Estado</label>
          <input v-model="form.estado" type="text" id="estado" class="form-control" />
        </div> -->
        <!-- Cidade -->
        <div class="col-md-3 mb-3">
          <label for="cidade" class="form-label">Cidade</label>
          <select v-model="form.cidade" id="cidade" class="form-select">
            <option value="">Todas</option>
            <option v-for="imb in cidades" :value="imb.cidade" :key="imb.cidade">{{imb.cidade}}</option>
          </select>
        </div>
        <!-- Bairro -->
        <div class="col-md-3 mb-3">
          <label for="bairro" class="form-label">Bairro</label>
          <!-- <input v-model="form.bairro" type="text" id="bairro" class="form-control" /> -->
          <select v-model="form.bairro" id="bairro" class="form-select">
            <option value="">Todas</option>
            <option v-for="imb in bairros" :value="imb.bairro" :key="imb.bairro">{{imb.bairro}}</option>
          </select>
        </div>
        <!-- Negócio -->
        <div class="col-md-3 mb-3">
          <label for="negocio" class="form-label">Negócio</label>
          <select v-model="form.negocio" id="negocio" class="form-select">
            <option value="">Todos</option>
            <option v-for="imb in negocios" :value="imb.negocio" :key="imb.negocio">{{imb.negocio}}</option>
          </select>
        </div>
        <!-- Finalidade/Tipo -->
        <div class="col-md-3 mb-3">
          <label for="finalidade" class="form-label">Finalidade/Tipo</label>
          <select v-model="form.finalidade" id="finalidade" class="form-select">
            <option value="">Todos</option>
            <option v-for="imb in finalidades" :value="imb.finalidade" :key="imb.finalidade">{{ imb.finalidade == 'Locacao' ? 'Locação' : imb.finalidade }}</option>
          </select>
        </div>
        <!-- Valor -->
        <!-- <input v-model="form.valormin" type="range" id="valormax" class="form-range" @change="alteraomax" /> -->
        <!-- <input v-model="form.valormax" type="range" id="valormax2" class="form-range" /> -->
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
          <label for="area" class="form-label">Área (m²)</label>
          <input v-model="form.area" type="number" id="area" class="form-control" />
        </div>
        <!-- Banheiros -->
        <div class="col-md-2 mb-3">
          <label for="banheiros" class="form-label">Banheiros</label>
          <input v-model="form.banheiros" type="number" id="banheiros" class="form-control" />
        </div>
        <!-- Dormitórios -->
        <div class="col-md-2 mb-3">
          <label for="dormitorios" class="form-label">Dormitórios</label>
          <input v-model="form.dormitorios" type="number" id="dormitorios" class="form-control" />
        </div>
        <!-- Garagens -->
        <div class="col-md-2 mb-3">
          <label for="garagens" class="form-label">Garagens</label>
          <input v-model="form.garagens" type="number" id="garagens" class="form-control" />
        </div>
        <!-- Salas -->
        <!-- <div class="col-md-2 mb-3">
          <label for="salas" class="form-label">Salas</label>
          <input v-model="form.salas" type="number" id="salas" class="form-control" />
        </div> -->
        <!-- Mobiliado -->
        <div class="col-md-2 mb-3">
          <label for="mobiliado" class="form-label">Mobiliado</label>
          <select v-model="form.mobiliado" id="mobiliado" class="form-select">
            <option value="" disabled>Selecione</option>
            <option value="sim">Sim</option>
            <option value="nao">Não</option>
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

    <h2 class="mt-5">Resultados</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Imobiliária</th>
          <th>Estado</th>
          <th>Cidade</th>
          <th>Bairro</th>
          <th>Negócio</th>
          <th>Finalidade</th>
          <th>Valor</th>
          <th>Área</th>
          <!-- <th>Banheiros</th>
          <th>Dormitórios</th>
          <th>Garagens</th> -->
          <!-- <th>Salas</th> -->
          <th>Mobiliado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td>{{ item.imobiliaria }}</td>
          <td>{{ item.estado }}</td>
          <td>{{ item.cidade }}</td>
          <td>{{ item.bairro }}</td>
          <td>{{ item.negocio }}</td>
          <td>{{ item.finalidade }}</td>
          <td>R$ {{ Math.round(item.valor).toLocaleString() }}</td>
          <td>{{ item.area }}</td>
          <!-- <td>{{ item.banheiros }}</td>
          <td>{{ item.dormitorios }}</td>
          <td>{{ item.garagens }}</td> -->
          <!-- <td>{{ item.salas }}</td> -->
          <td :class="item.mobiliado == '1' ? 'fw-bolder text-success' : 'text-danger'">{{ item.mobiliado == '1' ? "Sim" : "Não" }}</td>
        </tr>
      </tbody>
    </table>
    <!-- <button v-if="data.length < pagination.total" @click="loadMore">
      Carregar Mais
    </button> -->
    <!-- Paginação -->
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
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
 import {Money} from 'v-money'
// import RangeSlider from 'vue-range-slider'
// you probably need to import built-in style
// import 'vue-range-slider/dist/vue-range-slider.css'
// import VueThousandSeparator from 'vue-thousand-separator';


const form = reactive({
  imobiliaria: '',
  estado: '',
  cidade: '',
  bairro: '',
  negocio: '',
  finalidade: '',
  valormax: 0,
  valormin: 0,
});

const data = ref([]);
const imobiliarias = ref([]);
const cidades = ref([]);
const bairros = ref([]);
const negocios = ref([]);
const finalidades = ref([]);

const range = ref([-5, 5]);

const pagination = reactive({
  page: 1,
  pageSize: 20,
  total: 0,
});
const urlraiz = 'http://localhost:8080';

const fetchData = async () => {
  const response = await fetch(`${urlraiz}/imoveisex/getimoveis?page=${pagination.page}&pageSize=${pagination.pageSize}&imobiliaria=${form.imobiliaria}&estado=${form.estado}&cidade=${form.cidade}&bairro=${form.bairro}&negocio=${form.negocio}&finalidade=${form.finalidade}`);
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
  pagination.total = result.pagination.total;
};



// Atualizar a tabela com filtros
const handleFilter = () => {
  pagination.page = 1; // Resetar para a primeira página
  fetchData();
};

const changePage = (newPage) => {
  pagination.page = newPage;
  fetchData();
};
const alteraomax = () => {
  // console.log('chamou a function');
  if (form.valormax < form.valormin) {
    form.valormax = form.valormin + 1;
  }
  fetchData();
};

const totalPages = computed(() => Math.ceil(pagination.total / pagination.pageSize));


// Carregar mais páginas
// const loadMore = () => {
//   if (data.value.length < pagination.total) {
//     pagination.page += 1;
//     fetchData();
//   }
// };

onMounted(() => {
  fetchData();
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
</style>
