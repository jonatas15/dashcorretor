<template>
    <div class="avaliacao-container">
        <h2>Avaliação de Imóvel</h2>
        
        <!-- Mapa com círculo ao redor do ponto central -->
        <div class="map-section">
            <l-map
                ref="mapRef"
                style="height: 400px; width: 100%;"
                :zoom="15"
                :center="[lat, lng]"
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
            <!-- Campo 1: Fachada do Imóvel -->
            <div class="field">
                <label>Campo 1 - Fachada do Imóvel</label>
                <div class="streetview-controls">
                    <input type="text" v-model="apiKey" placeholder="Insira sua API Key do Google Maps" />
                    <button @click.prevent="fetchStreetView">Buscar do Street View</button>
                </div>
                <input type="file" accept="image/*" @change="handleFachadaUpload" />
                <img v-if="fachadaImage" :src="fachadaImage" alt="Fachada do Imóvel" class="preview-image" />
            </div>

            <!-- Campo 2: Ajuste do Valor Final -->
            <div class="field">
                <label>Campo 2 - Ajuste do Valor Final (R$)</label>
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
            </div>
            <div class="field-group">
                <div class="field">
                    <label>Campo 3 - Valor Máximo (R$)</label>
                    <input type="number" :value="maxValue" readonly />
                </div>
                <div class="field">
                    <label>Campo 4 - Valor Mínimo (R$)</label>
                    <input type="number" :value="minValue" readonly />
                </div>
            </div>

            <!-- Campo 5: Solicitante -->
            <div class="field">
                <label>Campo 5 - Solicitante</label>
                <textarea v-model="solicitante" rows="3"></textarea>
            </div>

            <!-- Campo 6: Finalidade da Avaliação -->
            <div class="field">
                <label>Campo 6 - Finalidade da Avaliação</label>
                <textarea v-model="finalidade" rows="3"></textarea>
            </div>

            <!-- Campo 7: Descrição do Imóvel -->
            <div class="field">
                <label>Campo 7 - Descrição do Imóvel</label>
                <textarea v-model="descricaoImovel" rows="5"></textarea>
            </div>

            <!-- Campo 8: Descrição da Região -->
            <div class="field">
                <label>Campo 8 - Descrição da Região</label>
                <textarea v-model="descricaoRegiao" rows="5"></textarea>
            </div>

            <!-- Campo 9: Metodologia da Avaliação -->
            <div class="field">
                <label>Campo 9 - Metodologia da Avaliação</label>
                <textarea v-model="metodologia" rows="5"></textarea>
            </div>

            <!-- Campo 10: Conclusão -->
            <div class="field">
                <label>Campo 10 - Conclusão</label>
                <textarea v-model="conclusao" rows="5"></textarea>
            </div>

            <!-- Campo 11: Anexar Fotos -->
            <div class="field">
                <label>Campo 11 - Anexar Fotos</label>
                <input type="file" accept="image/*" multiple @change="handleFotosUpload" />
                <div class="photos-preview">
                    <img v-for="(photo, index) in fotosPreviews" :key="index" :src="photo" alt="Foto anexada" class="preview-image small" />
                </div>
            </div>

            <!-- Botão de Exportar para PDF -->
            <button class="export-button" @click.prevent="exportToPDF">Exportar para PDF</button>
        </form>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'

// const props = defineProps({
//     medianValue: { type: Number, required: true },
//     lat: { type: Number, required: true },
//     lng: { type: Number, required: true }
// })
const props = {
    medianValue: 400000,
    lat: ref(-23.55052),
    lng: ref(-46.633308)
}
const lat = ref(-23.55052)
const lng = ref(-46.633308)
const latitudelongitude = [-23.55052, -46.633308]

// Ref para o mapa
const mapRef = ref(null)

// Estados
const adjustedValue = ref(props.medianValue)
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
const fachadaFile = ref(null) // Para armazenar o arquivo da fachada
const fotosFiles = ref([]) // Para armazenar os arquivos das fotos

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
    // Para PDF, vamos tratar como URL remota
}

// Upload de fachada
function handleFachadaUpload(event) {
    const file = event.target.files[0]
    if (file) {
        fachadaFile.value = file
        fachadaImage.value = URL.createObjectURL(file)
    }
}

// Upload de fotos
function handleFotosUpload(event) {
    const files = Array.from(event.target.files)
    files.forEach(file => {
        fotosFiles.value.push(file)
        fotosPreviews.value.push(URL.createObjectURL(file))
    })
}

// Função para converter imagem para base64
async function getBase64(fileOrUrl) {
    return new Promise((resolve, reject) => {
        if (typeof fileOrUrl === 'string') {
            // URL remota (Street View)
            const img = new Image()
            img.crossOrigin = 'Anonymous'
            img.src = fileOrUrl + (fileOrUrl.includes('?') ? '&' : '?') + 'cb=' + Date.now() // Cache bust
            img.onload = () => {
                const canvas = document.createElement('canvas')
                canvas.width = img.width
                canvas.height = img.height
                const ctx = canvas.getContext('2d')
                ctx.drawImage(img, 0, 0)
                resolve(canvas.toDataURL('image/jpeg'))
            }
            img.onerror = reject
        } else {
            // Arquivo local
            const reader = new FileReader()
            reader.onload = (e) => resolve(e.target.result)
            reader.onerror = reject
            reader.readAsDataURL(fileOrUrl)
        }
    })
}

// Inicialização do Mapa
function onMapReady(map) {
    // Adicionar círculo ao redor do centro (raio de 500 metros, ajustável se necessário)
    L.circle(latitudelongitude, {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 500 // Raio em metros
    }).addTo(map)
}

// Função auxiliar para adicionar texto com quebra de página
function addTextWithPageBreak(doc, text, x, y, options = {}) {
    if (y > 250) {
        doc.addPage()
        y = 10
    }
    doc.text(text, x, y, options)
    return y + (options.lineHeight || 10)
}

// Função auxiliar para adicionar linhas de texto com quebra de página
function addSplitTextWithPageBreak(doc, lines, x, y, fontSize = 10, lineHeight = 7) {
    doc.setFontSize(fontSize)
    lines.forEach(line => {
        if (y > 250) {
            doc.addPage()
            y = 10
        }
        doc.text(line, x, y)
        y += lineHeight
    })
    return y + 5 // Espaço extra após o bloco
}

// Função auxiliar para adicionar imagem com quebra de página
async function addImageWithPageBreak(doc, base64, format, x, y, width, height) {
    if (y + height > 250) {
        doc.addPage()
        y = 10
    }
    doc.addImage(base64, format, x, y, width, height)
    return y + height + 10 // Espaço extra
}

// Exportar para PDF
async function exportToPDF() {
    const doc = new jsPDF()
    let y = 10

    // Título
    doc.setFontSize(18)
    y = addTextWithPageBreak(doc, 'Relatório de Avaliação de Imóvel', 10, y, { lineHeight: 15 })

    // Data
    doc.setFontSize(12)
    y = addTextWithPageBreak(doc, 'Data: October 08, 2025', 10, y)

    // Mapa
    y = addTextWithPageBreak(doc, 'Mapa do Imóvel:', 10, y)
    if (mapRef.value) {
        try {
            const mapElement = mapRef.value.$el
            const canvas = await html2canvas(mapElement, {
                useCORS: true,
                allowTaint: true
            })
            const mapImg = canvas.toDataURL('image/png')
            y = await addImageWithPageBreak(doc, mapImg, 'PNG', 10, y, 180, 120)
        } catch (error) {
            console.error('Erro ao capturar mapa:', error)
            y = addTextWithPageBreak(doc, '(Mapa não pôde ser carregado)', 10, y)
        }
    } else {
        y = addTextWithPageBreak(doc, '(Mapa não disponível)', 10, y)
    }

    // Campo 1: Fachada
    y = addTextWithPageBreak(doc, 'Campo 1 - Fachada do Imóvel:', 10, y)
    if (fachadaImage.value) {
        try {
            const base64 = await getBase64(fachadaFile.value || fachadaImage.value)
            y = await addImageWithPageBreak(doc, base64, 'JPEG', 10, y, 180, 120)
        } catch (error) {
            console.error('Erro ao adicionar imagem da fachada:', error)
            y = addTextWithPageBreak(doc, '(Imagem não pôde ser carregada)', 10, y)
        }
    } else {
        y = addTextWithPageBreak(doc, 'Nenhuma imagem fornecida', 10, y)
    }

    // Campo 2: Valor Final
    y = addTextWithPageBreak(doc, `Campo 2 - Ajuste do Valor Final: R$ ${adjustedValue.value.toLocaleString('pt-BR')}`, 10, y)

    // Campos 3 e 4: Max e Min
    y = addTextWithPageBreak(doc, `Campo 3 - Valor Máximo: R$ ${maxValue.value.toLocaleString('pt-BR')}`, 10, y)
    y = addTextWithPageBreak(doc, `Campo 4 - Valor Mínimo: R$ ${minValue.value.toLocaleString('pt-BR')}`, 10, y)

    // Campo 5: Solicitante
    y = addTextWithPageBreak(doc, 'Campo 5 - Solicitante:', 10, y)
    const solicitanteLines = doc.splitTextToSize(solicitante.value, 180)
    y = addSplitTextWithPageBreak(doc, solicitanteLines, 10, y)
    doc.setFontSize(12)

    // Campo 6: Finalidade
    y = addTextWithPageBreak(doc, 'Campo 6 - Finalidade da Avaliação:', 10, y)
    const finalidadeLines = doc.splitTextToSize(finalidade.value, 180)
    y = addSplitTextWithPageBreak(doc, finalidadeLines, 10, y)
    doc.setFontSize(12)

    // Campo 7: Descrição Imóvel
    y = addTextWithPageBreak(doc, 'Campo 7 - Descrição do Imóvel:', 10, y)
    const descImovelLines = doc.splitTextToSize(descricaoImovel.value, 180)
    y = addSplitTextWithPageBreak(doc, descImovelLines, 10, y)
    doc.setFontSize(12)

    // Campo 8: Descrição Região
    y = addTextWithPageBreak(doc, 'Campo 8 - Descrição da Região:', 10, y)
    const descRegiaoLines = doc.splitTextToSize(descricaoRegiao.value, 180)
    y = addSplitTextWithPageBreak(doc, descRegiaoLines, 10, y)
    doc.setFontSize(12)

    // Campo 9: Metodologia
    y = addTextWithPageBreak(doc, 'Campo 9 - Metodologia da Avaliação:', 10, y)
    const metodoLines = doc.splitTextToSize(metodologia.value, 180)
    y = addSplitTextWithPageBreak(doc, metodoLines, 10, y)
    doc.setFontSize(12)

    // Campo 10: Conclusão
    y = addTextWithPageBreak(doc, 'Campo 10 - Conclusão:', 10, y)
    const conclusaoLines = doc.splitTextToSize(conclusao.value, 180)
    y = addSplitTextWithPageBreak(doc, conclusaoLines, 10, y)
    doc.setFontSize(12)

    // Campo 11: Fotos
    y = addTextWithPageBreak(doc, 'Campo 11 - Fotos Anexadas:', 10, y)
    for (let i = 0; i < fotosFiles.value.length; i++) {
        try {
            const base64 = await getBase64(fotosFiles.value[i])
            y = await addImageWithPageBreak(doc, base64, 'JPEG', 10, y, 90, 60)
        } catch (error) {
            console.error(`Erro ao adicionar foto ${i + 1}:`, error)
            y = addTextWithPageBreak(doc, `(Foto ${i + 1} não pôde ser carregada)`, 10, y)
        }
    }

    // Salvar PDF
    doc.save('avaliacao_imovel.pdf')
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

.export-button {
    padding: 10px 20px;
    background: #52c41a;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    align-self: center;
}
</style>