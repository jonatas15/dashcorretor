<template>
    <div class="avaliacao-container">
        <h2>Avaliação de Imóvel</h2>
        
        <!-- Mapa com círculo ao redor do ponto central -->
        <div class="map-section">
            <l-map
                ref="map"
                style="height: 400px; width: 100%;"
                :zoom="15"
                :center="[-29.6846, -53.8069]"
                :use-global-leaflet="true"
                @ready="onMapReady"
            >
                <l-tile-layer
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                />
                <l-marker :lat-lng="[lat, lng]"></l-marker>
            </l-map>
        </div>

        <!-- Formulário de Avaliação -->
        <form class="avaliacao-form">
            <!-- 1: Fachada do Imóvel -->
            <div class="field">
                <label>1 - Fachada do Imóvel</label>
                <div class="streetview-controls">
                    <input type="text" v-model="apiKey" placeholder="API Key do Google Maps" />
                    <button @click.prevent="fetchStreetView">Buscar do Street View</button>
                </div>
                <input type="file" accept="image/*" @change="handleFachadaUpload" />
                <img v-if="fachadaImage" :src="fachadaImage" alt="Fachada do Imóvel" class="preview-image" />
            </div>

            <!-- 2: Ajuste do Valor Final -->
            <div class="field">
                <label>2 - Ajuste do Valor Final (R$)</label>
                <input type="number" v-model="adjustedValue" />
            </div>

            <!-- Campos 3 e 4: Valores Máximo e Mínimo -->
            <div class="field-group">
                <div class="field">
                    <label>Porcentagem para Mais (%)</label>
                    <input type="number" v-model="percentPlus" min="0" step="0.1" />
                </div>
                <div class="field">
                    <label>Porcentagem para Menos (%)</label>
                    <input type="number" v-model="percentMinus" min="0" step="0.1" />
                </div>
                <div class="field">
                    <label>3 - Valor Máximo (R$)</label>
                    <input type="number" :value="maxValue" readonly />
                </div>
                <div class="field">
                    <label>4 - Valor Mínimo (R$)</label>
                    <input type="number" :value="minValue" readonly />
                </div>
            </div>

            <!-- 5: Solicitante -->
            <div class="field">
                <label>5 - Solicitante</label>
                <textarea v-model="solicitante" rows="3"></textarea>
            </div>

            <!-- 6: Finalidade da Avaliação -->
            <div class="field">
                <label>6 - Finalidade da Avaliação</label>
                <textarea v-model="finalidade" rows="3"></textarea>
            </div>

            <!-- 7: Descrição do Imóvel -->
            <div class="field">
                <label>7 - Descrição do Imóvel</label>
                <textarea v-model="descricaoImovel" rows="5"></textarea>
            </div>

            <!-- 8: Descrição da Região -->
            <div class="field">
                <label>8 - Descrição da Região</label>
                <textarea v-model="descricaoRegiao" rows="5"></textarea>
            </div>

            <!-- 9: Metodologia da Avaliação -->
            <div class="field">
                <label>9 - Metodologia da Avaliação</label>
                <textarea v-model="metodologia" rows="5"></textarea>
            </div>

            <!-- 10: Conclusão -->
            <div class="field">
                <label>10 - Conclusão</label>
                <textarea v-model="conclusao" rows="5"></textarea>
            </div>

            <!-- 11: Anexar Fotos -->
            <div class="field">
                <label>11 - Anexar Fotos</label>
                <input type="file" accept="image/*" multiple @change="handleFotosUpload" />
                <div class="photos-preview">
                    <img v-for="(photo, index) in fotosPreviews" :key="index" :src="photo" alt="Foto anexada" class="preview-image small" />
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

const props = defineProps({
    medianValue: { type: Number, required: true },
    lat: { type: Number, required: true },
    lng: { type: Number, required: true }
})

// para teste: passar às props lat e lng cooredenadas do centro de Santa Maria
props.lat = ref(-29.6846)
props.lng = ref(-53.8069)



// Estados
const adjustedValue = ref(400000)//ref(props.medianValue)
const percentPlus = ref(20) // Valor padrão para +%
const percentMinus = ref(20) // Valor padrão para -%
const solicitante = ref('')
const finalidade = ref('')
const descricaoImovel = ref('')
const descricaoRegiao = ref('')
const metodologia = ref('')
const conclusao = ref('')
const apiKey = ref('')
const fachadaImage = ref(null)
const fotosPreviews = ref([])

// Computeds para max e min
const maxValue = computed(() => adjustedValue.value * (1 + percentPlus.value / 100))
const minValue = computed(() => adjustedValue.value * (1 - percentMinus.value / 100))

// Função para buscar Street View
function fetchStreetView() {
    if (!apiKey.value) {
        alert('Insira a API Key do Google Maps.')
        return
    }
    fachadaImage.value = `https://maps.googleapis.com/maps/api/streetview?size=600x400&location=${props.lat},${props.lng}&key=${apiKey.value}`
}

// Upload de fachada
function handleFachadaUpload(event) {
    const file = event.target.files[0]
    if (file) {
        fachadaImage.value = URL.createObjectURL(file)
    }
}

// Upload de fotos
function handleFotosUpload(event) {
    const files = Array.from(event.target.files)
    files.forEach(file => {
        fotosPreviews.value.push(URL.createObjectURL(file))
    })
}

// Inicialização do Mapa
function onMapReady(map) {
    // Adicionar círculo ao redor do centro (raio de 500 metros, ajustável se necessário)
    // L.circle([props.lat, props.lng], {
    L.circle([-29.6846, -53.8069], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 500 // Raio em metros
    }).addTo(map)
}
</script>

<style scoped>
.avaliacao-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.map-section {
    margin-bottom: 20px;
}

.avaliacao-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.field-group {
    display: flex;
    gap: 20px;
}

.field-group .field {
    flex: 1;
}

label {
    font-weight: bold;
}

input, textarea {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

textarea {
    resize: vertical;
}

.streetview-controls {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.streetview-controls input {
    flex: 1;
}

.streetview-controls button {
    padding: 8px 16px;
    background: #1890ff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.preview-image {
    max-width: 600px;
    margin-top: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.photos-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
}

.small {
    max-width: 200px;
}
</style>