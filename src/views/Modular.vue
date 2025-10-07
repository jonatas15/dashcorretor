
<template>
  <div class="map-container">
    <div v-if="!mapReady" class="loading-overlay">Carregando mapa...</div>
    <l-map
      style="height: 100%; width: 100%"
      :zoom="13"
      :center="mapCenter"
      :use-global-leaflet="true"
      @ready="onMapReady"
    >
      <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />
      <l-feature-group ref="featureGroup">
        <l-geo-json
          v-for="(area, idx) in selectedAreas.filter(
            (a) => a.type !== 'Circle'
          )"
          :key="idx"
          :geojson="area"
          :options="{ color: 'blue', fillOpacity: 0.2, weight: 2 }"
        />
      </l-feature-group>
      <l-marker
        v-for="imovel in mapFilteredImoveis"
        :key="imovel.id"
        :lat-lng="[imovel.coordenadas.latitude, imovel.coordenadas.longitude]"
        :options="markerOptions(imovel)"
      >
        <l-popup>
          <div>
            <h4>{{ imovel.tipo }}</h4>
            <strong>R$ {{ imovel.preco }}</strong>
            <p>
              Coordenadas: {{ imovel.coordenadas.latitude }},
              {{ imovel.coordenadas.longitude }}
            </p>
          </div>
        </l-popup>
      </l-marker>
    </l-map>
    <div class="button-container">
      <button class="clear-button" @click="clearSelection">
        Limpar Seleção
      </button>
      <!-- <button class="show-table-button" @click="toggleTable">
{{ showTable ? 'Ocultar Tabela' : 'Exibir Imóveis Selecionados' }}
</button> -->
    </div>
    <div class="imoveis-counter">
      Imóveis visíveis no mapa: {{ mapFilteredImoveis.length }} /
      {{ imoveis.length }}
    </div>
  </div>
  <div class="table-container">
    <!-- <div v-if="showTable" class="table-container"> -->
    <div class="filter-form">
      <label>
        Tipo de Imóvel:
        <select v-model="filterTipo">
          <option value="">Todos</option>
          <option v-for="tipo in uniqueTipos" :key="tipo" :value="tipo">
            {{ tipo }}
          </option>
        </select>
      </label>
      <label>
        Endereço (trecho):
        <input
          type="text"
          v-model="filterEndereco"
          placeholder="Digite um trecho do endereço"
        />
      </label>
      <label>
        Preço aproximado (R$):
        <input type="number" v-model="filterPreco" placeholder="Ex: 300000" />
      </label>
      <label>
        Área útil aproximada (m²):
        <input type="number" v-model="filterArea" placeholder="Ex: 120" />
      </label>
      <button class="clear-filters" @click="clearFilters">
        Limpar Filtros
      </button>
    </div>
    <table class="imoveis-table">
      <thead>
        <tr>
          <th>Selecionar</th>
          <th>ID</th>
          <th>Imóvel</th>
          <th>Endereço</th>
          <th>Venda</th>
          <th>Área Privativa</th>
          <th>Latitude</th>
          <th>Longitude</th>
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
          <td>{{ imovel.coordenadas.latitude }}</td>
          <td>{{ imovel.coordenadas.longitude }}</td>
        </tr>
        <tr v-if="!paginatedImoveis.length">
          <td colspan="8">Nenhum imóvel encontrado</td>
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
  </div>
</template>
<script setup>
import { ref, computed, toRaw } from "vue";
import {
  LMap,
  LTileLayer,
  LMarker,
  LPopup,
  LFeatureGroup,
  LGeoJson,
} from "@vue-leaflet/vue-leaflet";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet-draw/dist/leaflet.draw.css";
import "leaflet-draw";
import booleanPointInPolygon from "@turf/boolean-point-in-polygon";
import { point, polygon } from "@turf/helpers";

console.log("Script setup inicializado");

const mapReady = ref(false);
const mapCenter = ref([-29.6914, -53.8008]); // Centro de Santa Maria, RS
const imoveis = ref([
  {
    id: 1,
    tipo: "Casa",
    preco: 350000,
    endereco: "Rua das Flores, 123, Bairro Camobi",
    area_util: 123,
    coordenadas: {
      latitude: -29.6987,
      longitude: -53.8024,
    },
  },
  {
    id: 2,
    tipo: "Apartamento",
    preco: 280000,
    endereco: "Avenida Rio Branco, 456, Bairro Centro",
    area_util: 120,
    coordenadas: {
      latitude: -29.6865,
      longitude: -53.8132,
    },
  },
  {
    id: 3,
    tipo: "Casa",
    preco: 420000,
    endereco: "Rua General Neto, 789, Bairro Nossa Senhora de Fátima",
    area_util: 140,
    coordenadas: {
      latitude: -29.6723,
      longitude: -53.7918,
    },
  },
  {
    id: 4,
    tipo: "Apartamento",
    preco: 310000,
    endereco: "Rua Venâncio Aires, 101, Bairro Patronato",
    area_util: 130,
    coordenadas: {
      latitude: -29.7041,
      longitude: -53.8276,
    },
  },
  {
    id: 5,
    tipo: "Terreno",
    preco: 150000,
    endereco: "Rua dos Andradas, 202, Bairro Itararé",
    area_util: 110,
    coordenadas: {
      latitude: -29.6908,
      longitude: -53.7794,
    },
  },
  {
    id: 6,
    tipo: "Casa",
    preco: 380000,
    endereco: "Rua Silva Jardim, 303, Bairro Bonfim",
    area_util: 100,
    coordenadas: {
      latitude: -29.6789,
      longitude: -53.8056,
    },
  },
  {
    id: 7,
    tipo: "Apartamento",
    preco: 260000,
    endereco: "Rua Duque de Caxias, 404, Bairro Medianeira",
    area_util: 150,
    coordenadas: {
      latitude: -29.6954,
      longitude: -53.8187,
    },
  },
  {
    id: 8,
    tipo: "Casa",
    preco: 450000,
    endereco: "Rua Tuiuti, 505, Bairro São José",
    area_util: 110,
    coordenadas: {
      latitude: -29.6672,
      longitude: -53.7943,
    },
  },
  {
    id: 9,
    tipo: "Terreno",
    preco: 180000,
    endereco: "Rua Pinheiro Machado, 606, Bairro Salgado Filho",
    area_util: 120,
    coordenadas: {
      latitude: -29.7019,
      longitude: -53.8115,
    },
  },
  {
    id: 10,
    tipo: "Apartamento",
    preco: 320000,
    endereco: "Rua Floriano Peixoto, 707, Bairro Centro",
    area_util: 125,
    coordenadas: {
      latitude: -29.6883,
      longitude: -53.7998,
    },
  },
]);
const selectedAreas = ref([]);
const showTable = ref(false); // Controla a visibilidade da tabela

// Filtros adicionais
const filterTipo = ref("");
const filterEndereco = ref("");
const filterPreco = ref(null);
const filterArea = ref(null);

// Paginação
const currentPage = ref(1);
const itemsPerPage = ref(20); // Ajuste conforme necessário para volumes grandes

// Seleção de imóveis
const selectedIds = ref(new Set());

// Mediana
const currentMedian = ref(0);

const mapFilteredImoveis = computed(() => {
  console.log(
    "Calculando mapFilteredImoveis, áreas:",
    selectedAreas.value.length
  );
  if (!selectedAreas.value.length) return imoveis.value;
  return imoveis.value.filter((imovel) => {
    const pt = point([
      imovel.coordenadas.longitude,
      imovel.coordenadas.latitude,
    ]);
    return selectedAreas.value.some((area) => {
      try {
        if (area.type === "Circle") {
          const center = L.latLng(area.center[0], area.center[1]);
          const distance = center.distanceTo(
            L.latLng(imovel.coordenadas.latitude, imovel.coordenadas.longitude)
          );
          return distance <= area.radius;
        } else if (area.geometry && area.geometry.coordinates) {
          const poly = polygon(area.geometry.coordinates);
          return booleanPointInPolygon(pt, poly);
        }
        return false;
      } catch (error) {
        console.error("Erro ao verificar ponto em área:", error);
        return false;
      }
    });
  });
});

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

function markerOptions(imovel) {
  try {
    return {
      icon: L.icon({
        iconUrl: "/images/marker-icon.png",
        shadowUrl: "/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      }),
      title: imovel.nome,
    };
  } catch (error) {
    console.error("Erro ao configurar ícone do marcador:", error);
    return { title: imovel.nome };
  }
}

function onMapReady(map) {
  console.log("Mapa inicializado:", map);
  mapReady.value = true;
  try {
    const rawMap = toRaw(map);
    const drawnItems = new L.FeatureGroup();
    rawMap.addLayer(drawnItems);

    const drawControl = new L.Control.Draw({
      position: "topleft",
      draw: {
        polygon: {
          shapeOptions: { color: "blue", weight: 2, fillOpacity: 0.2 },
          allowIntersection: false,
          showArea: true,
        },
        marker: false,
        polyline: false,
        rectangle: false,
        circle: true,
        circlemarker: false,
      },
      edit: {
        featureGroup: drawnItems,
        edit: {
          selectedPathOptions: {
            color: "#ff0000",
            fillColor: "#ff0000",
            fillOpacity: 0.3,
          },
        },
        remove: true,
      },
    });
    rawMap.addControl(drawControl);

    rawMap.on(L.Draw.Event.CREATED, function (event) {
      const layer = event.layer;
      drawnItems.addLayer(layer);
      if (layer instanceof L.Polygon) {
        const geojson = layer.toGeoJSON();
        selectedAreas.value.push(geojson);
        console.log("Polígono criado:", geojson);
      } else if (layer instanceof L.Circle) {
        const center = layer.getLatLng();
        const radius = layer.getRadius();
        selectedAreas.value.push({
          type: "Circle",
          center: [center.lat, center.lng],
          radius: radius,
        });
        console.log("Círculo criado:", { center, radius });
      }
    });

    rawMap.on(L.Draw.Event.EDITED, function (event) {
      const layers = event.layers;
      selectedAreas.value.length = 0;
      layers.eachLayer(function (layer) {
        if (layer instanceof L.Polygon) {
          selectedAreas.value.push(layer.toGeoJSON());
        } else if (layer instanceof L.Circle) {
          const center = layer.getLatLng();
          const radius = layer.getRadius();
          selectedAreas.value.push({
            type: "Circle",
            center: [center.lat, center.lng],
            radius: radius,
          });
        }
      });
      console.log("Camadas editadas:", selectedAreas.value);
    });

    rawMap.on(L.Draw.Event.DELETED, function (event) {
      const layers = event.layers;
      layers.eachLayer(function (layer) {
        if (layer instanceof L.Polygon) {
          const geojson = layer.toGeoJSON();
          selectedAreas.value = selectedAreas.value.filter(
            (area) =>
              area.type !== "Circle" &&
              JSON.stringify(area) !== JSON.stringify(geojson)
          );
        } else if (layer instanceof L.Circle) {
          const center = layer.getLatLng();
          const radius = layer.getRadius();
          selectedAreas.value = selectedAreas.value.filter(
            (area) =>
              area.type !== "Circle" ||
              area.center[0] !== center.lat ||
              area.center[1] !== center.lng ||
              area.radius !== radius
          );
        }
      });
      console.log("Camada(s) deletada(s):", selectedAreas.value);
    });
  } catch (error) {
    console.error("Erro em onMapReady:", error);
  }
}

function clearSelection() {
  selectedAreas.value.length = 0;
  if (mapReady.value && $refs.featureGroup?.mapObject) {
    toRaw($refs.featureGroup.mapObject).clearLayers();
  }
  showTable.value = false; // Ocultar tabela ao limpar seleção
  clearFilters(); // Limpar filtros ao limpar seleção
  console.log("Seleção manualmente limpa");
}

function toggleTable() {
  showTable.value = !showTable.value;
  console.log("Tabela visível:", showTable.value);
}

// Fallback para mapReady
setTimeout(() => {
  if (!mapReady.value) {
    console.warn("Evento ready não disparado, forçando mapReady = true");
    mapReady.value = true;
  }
}, 5000);
</script>
<style scoped>
.map-container {
  height: 100vh;
  width: 100%;
  position: relative;
}

.loading-overlay {
  position: absolute;
  top: 10px;
  left: 10px;
  z-index: 1000;
  background: rgba(255, 255, 255, 0.8);
  padding: 8px;
  border-radius: 4px;
}

.button-container {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 1000;
  display: flex;
  gap: 10px;
}

.clear-button,
.show-table-button {
  padding: 8px 16px;
  background: #ff4d4f;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.show-table-button {
  background: #1890ff;
}

.imoveis-counter {
  position: absolute;
  bottom: 10px;
  left: 10px;
  z-index: 1000;
  background: rgba(255, 255, 255, 0.8);
  padding: 8px;
  border-radius: 4px;
}

.table-container {
  /* position: absolute; */
  margin-top: 70px;
  bottom: 50px;
  left: 10px;
  z-index: 1000;
  background: rgba(255, 255, 255, 0.95);
  padding: 16px;
  border-radius: 8px;
  /* max-height: 300px; */
  overflow-y: auto;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.filter-form {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 16px;
  align-items: center;
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
</style>