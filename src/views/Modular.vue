<template>
  <div class="container">
    <div class="filter-form row">
      <label class="col-md-3 col-sm-6 align-items-left">
        Tipo de Imóvel:
        <select v-model="filterTipo">
          <option value="">Todos</option>
          <option v-for="tipo in uniqueTipos" :key="tipo" :value="tipo">
            {{ tipo }}
          </option>
        </select>
      </label>
      <label class="col-md-3 col-sm-6 align-items-left">
        Endereço (trecho):
        <input
          type="text"
          v-model="filterEndereco"
          placeholder="Digite um trecho do endereço"
        />
      </label>
      <label class="col-md-3 col-sm-6 align-items-left">
        Preço aproximado (R$):
        <input type="number" v-model="filterPreco" placeholder="Ex: 300000" />
      </label>
      <label class="col-md-3 col-sm-6 align-items-left">
        Área útil aproximada (m²):
        <input type="number" v-model="filterArea" placeholder="Ex: 120" />
      </label>
      <!-- Filtro de bairros, botão que mostra e esconde a lista de bairros -->
      <!-- <button @click="showBairros = !showBairros">
        {{ showBairros ? "Esconder" : "Mostrar" }} Bairros
      </button> -->
      <!-- mostra os bairros em popup quando clicar no botão acima -->

      <div class="col-md-12 my-3">
        <label style="cursor: pointer" @click="showBairros = !showBairros">Bairros: {{ showBairros ? "&#8593;" : "&#8595;" }} | {{ selectedBairros.length === 0
            ? "Nenhum bairro selecionado"
            : selectedBairros.join(", ") }}</label>
        <div class="row" v-if="showBairros">

          <div v-for="bairro in uniqueBairros" :key="bairro" class="col-md-3 col-sm-6 align-items-left">
            <input type="checkbox" :value="bairro" v-model="selectedBairros" />
            {{ bairro }}
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <button class="clear-filters" @click="clearFilters">
          Limpar Filtros
        </button>
      </div>
    </div>
    <hr />
        <!-- {{
          selectedBairros.length === 0
            ? "Nenhum bairro selecionado"
            : selectedBairros.join(", ")
        }} -->
    <table class="imoveis-table">
      <thead>
        <tr>
          <th>Selecionar</th>
          <th>ID</th>
          <th>Imóvel</th>
          <th>Endereço</th>
          <th>Venda</th>
          <th>Área Privativa</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="imovel in paginatedImoveis" :key="imovel.id">
          <td>
            <input
              type="checkbox"
              :checked="selectedIds.has(imovel.id)"
              @change="toggleSelect(imovel.id)"
            />
          </td>
          <td>{{ imovel.id }}</td>
          <td>{{ imovel.tipo }}</td>
          <td>{{ imovel.endereco }}</td>
          <td>R$ {{ imovel.preco.toLocaleString("pt-BR") }}</td>
          <td>{{ imovel.area_util }} m²</td>
        </tr>
        <tr v-if="!paginatedImoveis.length">
          <td colspan="6">Nenhum imóvel encontrado</td>
        </tr>
      </tbody>
    </table>
    <div class="pagination" v-if="totalPages > 1">
      <button @click="prevPage" :disabled="currentPage === 1">Anterior</button>
      <span>Página {{ currentPage }} de {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages">
        Próxima
      </button>
    </div>
    <div class="median-section">
      <div class="median-display">
        Mediana de valor sugerido para novo imóvel: R$
        {{ currentMedian.toLocaleString("pt-BR") }}
      </div>
      <button class="update-button" @click="updateMedian">
        Atualizar Mediana
      </button>
    </div>
    <div class="imoveis-counter">
      Imóveis filtrados: {{ filteredImoveis.length }} /
      {{ imoveis.length }}
    </div>
  </div>
</template>
<script setup>
import { ref, computed, onMounted } from "vue";

const showBairros = ref(false);

console.log("Script setup inicializado");

const imoveis = ref([
  {
    id: 1,
    tipo: "Casa",
    preco: 350000,
    endereco: "Rua das Flores, 123, Bairro Camobi",
    area_util: 123,
  },
  {
    id: 2,
    tipo: "Apartamento",
    preco: 280000,
    endereco: "Avenida Rio Branco, 456, Bairro Centro",
    area_util: 120,
  },
  {
    id: 3,
    tipo: "Casa",
    preco: 420000,
    endereco: "Rua General Neto, 789, Bairro Nossa Senhora de Fátima",
    area_util: 140,
  },
  {
    id: 4,
    tipo: "Apartamento",
    preco: 310000,
    endereco: "Rua Venâncio Aires, 101, Bairro Patronato",
    area_util: 130,
  },
  {
    id: 5,
    tipo: "Terreno",
    preco: 150000,
    endereco: "Rua dos Andradas, 202, Bairro Itararé",
    area_util: 110,
  },
  {
    id: 6,
    tipo: "Casa",
    preco: 38000000,
    endereco: "Rua Silva Jardim, 303, Bairro Bonfim",
    area_util: 100,
  },
  {
    id: 7,
    tipo: "Apartamento",
    preco: 260000,
    endereco: "Rua Duque de Caxias, 404, Bairro Medianeira",
    area_util: 150,
  },
  {
    id: 8,
    tipo: "Casa",
    preco: 450000,
    endereco: "Rua Tuiuti, 505, Bairro São José",
    area_util: 110,
  },
  {
    id: 9,
    tipo: "Terreno",
    preco: 180000,
    endereco: "Rua Pinheiro Machado, 606, Bairro Salgado Filho",
    area_util: 120,
  },
  {
    id: 10,
    tipo: "Apartamento",
    preco: 320000,
    endereco: "Rua Floriano Peixoto, 707, Bairro Centro",
    area_util: 125,
  },
]);

// receber os imóveis da mesma API de Imoveis.vue aqui:
const apiImoveis = ref([]);
// Simular chamada API
onMounted(async () => {
  const response = await fetch("URL_DA_SUA_API_AQUI");
  apiImoveis.value = await response.json();
  imoveis.value = apiImoveis.value;
});

// Filtros adicionais
const filterTipo = ref("");
const filterEndereco = ref("");
const filterPreco = ref(null);
const filterArea = ref(null);
const selectedBairros = ref([]);

// Paginação
const currentPage = ref(1);
const itemsPerPage = ref(20); // Ajuste conforme necessário para volumes grandes

// Seleção de imóveis
const selectedIds = ref(new Set());

// Mediana
const currentMedian = ref(0);

const mapFilteredImoveis = computed(() => {
  if (selectedBairros.value.length === 0) return imoveis.value;
  return imoveis.value.filter((imovel) => {
    const bairro = extractBairroFromEndereco(imovel.endereco);
    return selectedBairros.value.includes(bairro);
  });
});

function extractBairroFromEndereco(endereco) {
  const match = endereco.match(/Bairro\s(.*)$/i);
  return match ? match[1].trim() : null;
}

const filteredImoveis = computed(() => {
  return mapFilteredImoveis.value.filter((imovel) => {
    let matches = true;

    if (filterTipo.value && imovel.tipo !== filterTipo.value) {
      matches = false;
    }

    if (
      filterEndereco.value &&
      !imovel.endereco
        .toLowerCase()
        .includes(filterEndereco.value.toLowerCase())
    ) {
      matches = false;
    }

    if (filterPreco.value !== null) {
      const precoNum = parseFloat(filterPreco.value);
      const minPreco = precoNum * 0.8;
      const maxPreco = precoNum * 1.2;
      if (imovel.preco < minPreco || imovel.preco > maxPreco) {
        matches = false;
      }
    }

    if (filterArea.value !== null) {
      const areaNum = parseFloat(filterArea.value);
      const minArea = areaNum * 0.8;
      const maxArea = areaNum * 1.2;
      if (imovel.area_util < minArea || imovel.area_util > maxArea) {
        matches = false;
      }
    }

    return matches;
  });
});

const uniqueTipos = computed(() => {
  const tipos = new Set(mapFilteredImoveis.value.map((imovel) => imovel.tipo));
  return Array.from(tipos);
});

const uniqueBairros = computed(() => {
  const bairros = new Set(
    imoveis.value.map((imovel) => extractBairroFromEndereco(imovel.endereco))
  );
  return Array.from(bairros).filter((b) => b);
});

const totalPages = computed(() =>
  Math.ceil(filteredImoveis.value.length / itemsPerPage.value)
);

const paginatedImoveis = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredImoveis.value.slice(start, end);
});

function prevPage() {
  if (currentPage.value > 1) currentPage.value--;
}

function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++;
}

function clearFilters() {
  filterTipo.value = "";
  filterEndereco.value = "";
  filterPreco.value = null;
  filterArea.value = null;
  selectedBairros.value = [];
  currentPage.value = 1;
  selectedIds.value.clear();
  currentMedian.value = 0;
}

function toggleSelect(id) {
  if (selectedIds.value.has(id)) {
    selectedIds.value.delete(id);
  } else {
    selectedIds.value.add(id);
  }
}

function updateMedian() {
  const imoveisToUse =
    selectedIds.value.size > 0
      ? filteredImoveis.value.filter((imovel) =>
          selectedIds.value.has(imovel.id)
        )
      : filteredImoveis.value;

  if (imoveisToUse.length === 0) {
    currentMedian.value = 0;
    return;
  }

  const prices = imoveisToUse
    .map((imovel) => imovel.preco)
    .sort((a, b) => a - b);
  const mid = Math.floor(prices.length / 2);
  currentMedian.value =
    prices.length % 2 === 0 ? (prices[mid - 1] + prices[mid]) / 2 : prices[mid];
}
</script>
<style scoped>
.container {
  padding: 20px;
}

.filter-form {
  display: flex;
  flex-wrap: wrap;
  /* gap: 10px; */
  margin-bottom: 16px;
  align-items: center;
}

.bairros-filter {
  display: flex;
  flex-direction: column;
  gap: 5px;
  /* aui transformo ele numa popup */
  max-height: 150px;
  overflow-y: auto;
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 4px;
  background: #fafafa;
  width: 200px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  /* position: absolute; */
  z-index: 10;
  /* posiciona ele abaixo do botão */
  position: inherit;
  top: 100px;
  left: 20px;
  /* fim popup */
}

.filter-form label {
  display: flex;
  flex-direction: column;
  font-size: 14px;
}

.filter-form select,
.filter-form input {
  padding: 6px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.clear-filters {
  padding: 6px 12px;
  background: #ff4d4f;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 150px;
  float: right !important;
}

.imoveis-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.imoveis-table th,
.imoveis-table td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.imoveis-table th {
  background: #f0f0f0;
  font-weight: bold;
}

.imoveis-table tr:hover {
  background: #f5f5f5;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-top: 16px;
}

.pagination button {
  padding: 6px 12px;
  background: #1890ff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
}

.pagination button:disabled {
  background: #ddd;
  cursor: not-allowed;
}

.median-section {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.median-display {
  font-size: 24px;
  font-weight: bold;
  padding: 10px 20px;
  background: #f0f0f0;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.update-button {
  padding: 8px 16px;
  background: #52c41a;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

.imoveis-counter {
  margin-top: 10px;
  background: rgba(255, 255, 255, 0.8);
  padding: 8px;
  border-radius: 4px;
  text-align: center;
}
.align-items-left {
  align-items: flex-start !important;
  text-align: left !important;
}
input[type="checkbox"] {
  transform: scale(1.2);
  margin-right: 8px;
}
input[type="text"], input[type="number"], select {
  width: 100%;
}

</style>