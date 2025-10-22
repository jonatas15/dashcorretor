<template>
    <div class="avaliacao-container">
        <h2>Avaliação de Imóvel</h2>

        <h3>Bairros Pesquisados: {{ props.bairros.join(', ') }}</h3>
        
        <!-- Mapa com círculo ao redor do ponto central -->
        <div class="map-section">
            <l-map
                ref="mapRef"
                style="height: 400px; width: 100%;"
                :zoom="15"
                :center="center"
                :use-global-leaflet="true"
                :options="{ preferCanvas: true }"
                @ready="onMapReady"
            >
                <l-tile-layer
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                />
                <l-marker :lat-lng="center"></l-marker>
            </l-map>
            <div class="streetview-controls mt-3">
                <button @click.prevent="updateMapFromLocal" class="btn btn-primary">Atualizar Mapa para Bairros</button>
            </div>
        </div>

        <h3>Imóveis Comparáveis Utilizados na Mediana</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imobiliária</th>
                    <th>Cidade</th>
                    <th>Bairro</th>
                    <th>Negócio</th>
                    <th>Finalidade</th>
                    <th>Valor</th>
                    <th>Área (m²)</th>
                    <th>Cômodos</th>
                    <th>Mobiliado</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in imoveis" :key="index">
                    <td>{{ item.imobiliaria ? item.imobiliaria : 'N/A' }}</td>
                    <td>{{ item.cidade }}</td>
                    <td>{{ item.bairro }}</td>
                    <td>{{ item.negocio }}</td>
                    <td>{{ item.finalidade == 'Locacao' ? 'Locação' : item.finalidade }}</td>
                    <td>R$ {{ Math.round(item.valor).toLocaleString() }}</td>
                    <td>{{ Math.round(item.area).toLocaleString() }}</td>
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

        <!-- Formulário de Avaliação -->
        <form class="avaliacao-form">
            <!-- Campo 1: Fachada do Imóvel -->
            <div class="field">
                <label>Fachada do Imóvel</label>
                <div class="streetview-controls">
                    <input type="text" v-model="apiKey" placeholder="Insira sua API Key do Google Maps" />
                    <button @click.prevent="fetchStreetView">Buscar do Street View</button>
                </div>
                <input type="file" accept="image/*" @change="handleFachadaUpload" />
                <img v-if="fachadaImage" :src="fachadaImage" alt="Fachada do Imóvel" class="preview-image" />
            </div>

            <!-- Campo 2: Ajuste do Valor Final -->
            <div class="field">
                <label>Ajuste do Valor Final (R$)</label>
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
                    <label>Valor Máximo (R$)</label>
                    <input type="number" :value="maxValue" readonly />
                </div>
                <div class="field">
                    <label>Valor Mínimo (R$)</label>
                    <input type="number" :value="minValue" readonly />
                </div>
            </div>

            <!-- Campo 5: Solicitante -->
            <div class="field">
                <label>Solicitante</label>
                <textarea v-model="solicitante" rows="3"></textarea>
            </div>

            <!-- Campo 6: Finalidade da Avaliação -->
            <div class="field">
                <label>Finalidade da Avaliação</label>
                <textarea v-model="finalidade" rows="3"></textarea>
            </div>

            <!-- Campo 7: Descrição do Imóvel -->
            <div class="field">
                <label>Descrição do Imóvel</label>
                <textarea v-model="descricaoImovel" rows="5"></textarea>
            </div>

            <!-- Campo 8: Descrição da Região -->
            <div class="field">
                <label>Descrição da Região</label>
                <textarea v-model="descricaoRegiao" rows="5"></textarea>
            </div>

            <!-- Campo 9: Metodologia da Avaliação -->
            <div class="field">
                <label>Metodologia da Avaliação</label>
                <textarea v-model="metodologia" rows="5"></textarea>
            </div>

            <!-- Campo 10: Conclusão -->
            <div class="field">
                <label>Conclusão</label>
                <textarea v-model="conclusao" rows="5"></textarea>
            </div>

            <!-- Campo 11: Anexar Fotos -->
            <div class="field">
                <label>Anexar Fotos</label>
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
import { ref, computed, watch } from 'vue'
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import html2canvas from 'html2canvas'
import bairrosCoords from '@/assets/jsons/bairrosltlg.json'

const props = defineProps({
    mediana: { type: Number, required: true },
    imoveis: { type: Array, default: () => [] },
    bairros: { type: Array, default: () => [] },
    cidade: { type: String, default: 'Santa Maria' }
})

//vamos limitar os imóveis a 10 para evitar lentidão
const imoveis = computed(() => {
    return props.imoveis.slice(0, 10)
})

// Ref para o mapa
const mapRef = ref(null)
// Loren Ipsum for testing
const loremIpsum = `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.`
// Estados
const adjustedValue = ref(props.mediana)
const percentPlus = ref(20) // Valor padrão para +%
const percentMinus = ref(20) // Valor padrão para -%
const solicitante = ref(loremIpsum) //ref('')
const finalidade = ref(loremIpsum) //ref('')
const descricaoImovel = ref(loremIpsum) //ref('')
const descricaoRegiao = ref(loremIpsum) //ref('')
const metodologia = ref(loremIpsum) //ref('')
const conclusao = ref(loremIpsum) //ref('')
const apiKey = ref('')
const fachadaImage = ref(null)
const fotosPreviews = ref([])
const fachadaFile = ref(null) // Para armazenar o arquivo da fachada
const fotosFiles = ref([]) // Para armazenar os arquivos das fotos
const center = ref([-29.688, -53.805])
const bairroRadius = ref(500) // Raio fixo para cada bairro

// Atualizar adjustedValue quando props.mediana mudar
watch(() => props.mediana, (newVal) => {
  adjustedValue.value = newVal;
})

// Computeds para max e min
const maxValue = computed(() => adjustedValue.value * (1 + percentPlus.value / 100))
const minValue = computed(() => adjustedValue.value * (1 - percentMinus.value / 100))

// Normalizar as chaves do JSON para lowercase
const normalizedCoords = {};
Object.keys(bairrosCoords).forEach(key => {
  normalizedCoords[key.toLowerCase().trim()] = bairrosCoords[key];
});

// Função para calcular distância (Haversine)
function distance(lat1, lon1, lat2, lon2) {
    const R = 6371; // km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

// Função para atualizar mapa a partir do JSON local com múltiplos círculos
function updateMapFromLocal() {
    if (props.bairros.length === 0) {
        alert('Nenhum bairro para atualizar o mapa.');
        return;
    }

    let points = [];
    props.bairros.forEach(bairro => {
        if (typeof bairro !== 'string') {
            console.warn('Item não é uma string:', bairro);
            return; // Pular itens que não são strings
        }
        const normalizedBairro = bairro.toLowerCase().trim(); // Normalizar para lookup
        if (normalizedCoords[normalizedBairro]) {
            const { latitude, longitude } = normalizedCoords[normalizedBairro];
            points.push({ lat: parseFloat(latitude), lng: parseFloat(longitude) });
        }
    });

    if (points.length > 0) {
        // Calcular centro (média)
        let sumLat = 0, sumLng = 0;
        points.forEach(p => {
            sumLat += p.lat;
            sumLng += p.lng;
        });
        center.value = [sumLat / points.length, sumLng / points.length];

        // Atualizar mapa
        if (mapRef.value && mapRef.value.leafletObject) {
            const map = mapRef.value.leafletObject;
            map.setView(center.value);
            // Remover círculos antigos se existirem
            map.eachLayer(layer => {
                if (layer instanceof L.Circle) {
                    map.removeLayer(layer);
                }
            });
            // Adicionar um círculo para cada bairro
            points.forEach(p => {
                L.circle([p.lat, p.lng], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: bairroRadius.value
                }).addTo(map);
            });
            // Ajustar zoom para encaixar todos os pontos
            const bounds = L.latLngBounds(points.map(p => [p.lat, p.lng]));
            map.fitBounds(bounds, { padding: [50, 50] });
        }
    } else {
        alert('Nenhum bairro encontrado no arquivo local.');
    }
}

// Função para buscar Street View (usando o centro calculado)
function fetchStreetView() {
    if (!apiKey.value) {
        alert('Insira a API Key do Google Maps.');
        return;
    }
    fachadaImage.value = `https://maps.googleapis.com/maps/api/streetview?size=600x400&location=${center.value[0]},${center.value[1]}&key=${apiKey.value}`;
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
    // Adicionar círculo inicial
    L.circle(center.value, {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: bairroRadius.value
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
    y = addTextWithPageBreak(doc, `Data: ${new Date().toLocaleDateString('pt-BR')}`, 10, y)

    // Bairros Pesquisados
    y = addTextWithPageBreak(doc, `Bairros Pesquisados: ${props.bairros.join(', ')}`, 10, y)

    // Mapa
    y = addTextWithPageBreak(doc, 'Mapa da Região:', 10, y)
    if (mapRef.value) {
        try {
            const map = mapRef.value.leafletObject;
            map.invalidateSize();
            await new Promise(resolve => setTimeout(resolve, 500)); // Delay para renderização
            const mapElement = mapRef.value.$el
            const canvas = await html2canvas(mapElement, {
                useCORS: true,
                allowTaint: true,
                scale: 2 // Maior resolução para melhor qualidade
            })
            const mapImg = canvas.toDataURL('image/png')
            const pdfWidth = 190;
            const pdfHeight = (canvas.height / canvas.width) * pdfWidth;
            y = await addImageWithPageBreak(doc, mapImg, 'PNG', 10, y, pdfWidth, pdfHeight)
        } catch (error) {
            console.error('Erro ao capturar mapa:', error)
            y = addTextWithPageBreak(doc, '(Mapa não pôde ser carregado)', 10, y)
        }
    } else {
        y = addTextWithPageBreak(doc, '(Mapa não disponível)', 10, y)
    }

    // Imóveis Comparáveis
    y = addTextWithPageBreak(doc, 'Imóveis Comparáveis:', 10, y)
    const columns = ['Imobiliária', 'Cidade', 'Bairro', 'Negócio', 'Finalidade', 'Valor', 'Área (m²)', 'Dormitórios', 'Banheiros', 'Garagens', 'Mobiliado']
    const rows = imoveis.value.map(item => [
        item.imobiliaria || 'N/A',
        item.cidade || 'N/A',
        item.bairro || 'N/A',
        item.negocio || 'N/A',
        item.finalidade == 'Locacao' ? 'Locação' : item.finalidade || 'N/A',
        `R$ ${Math.round(item.valor).toLocaleString('pt-BR')}`,
        Math.round(item.area).toLocaleString('pt-BR'),
        item.dormitorios || 'N/A',
        item.banheiros || 'N/A',
        item.garagens || 'N/A',
        item.mobiliado == 1 ? 'Mobiliado' : item.mobiliado == 2 ? 'Semi-mobiliado' : 'Não mobiliado'
    ])
    autoTable(doc, {
        head: [columns],
        body: rows,
        startY: y,
        theme: 'grid',
        styles: { fontSize: 8 }
    })
    y = doc.lastAutoTable.finalY + 10

    // Campo 1: Fachada
    y = addTextWithPageBreak(doc, 'Campo 1 - Fachada do Imóvel:', 10, y)
    if (fachadaImage.value) {
        try {
            const base64 = await getBase64(fachadaFile.value || fachadaImage.value)
            y = await addImageWithPageBreak(doc, base64, 'JPEG', 10, y, 190, 120)
        } catch (error) {
            console.error('Erro ao adicionar imagem da fachada:', error)
            y = addTextWithPageBreak(doc, '(Imagem não pôde ser carregada)', 10, y)
        }
    } else {
        y = addTextWithPageBreak(doc, 'Nenhuma imagem fornecida', 10, y)
    }
    // Aqui criar uma caixa estilizada com sombra sobre o título ajuste do valor final
    doc.setDrawColor(0)
    doc.setFillColor(220, 220, 220)
    doc.rect(10, y - 8, 190, 10, 'F')
    // Campo 2: Valor Final
    doc.setFontSize(16)
    y = addTextWithPageBreak(doc, `Ajuste do Valor Final: R$ ${adjustedValue.value.toLocaleString('pt-BR')}`, 100, y, { align: 'center', fontWeight: 'bold' })
    //fechando a caixa estilizada
    doc.setDrawColor(0)
    doc.rect(10, y - 18, 190, 10)
    
    // Campos 3 e 4: Max e Min
    doc.setDrawColor(0)
    doc.setFillColor(220, 220, 220)
    doc.rect(10, y - 8, 190, 10, 'F')
    doc.setFontSize(14)
    y = addTextWithPageBreak(doc, `Valor Máximo: R$ ${maxValue.value.toLocaleString('pt-BR')} | Valor Mínimo: R$ ${minValue.value.toLocaleString('pt-BR')}`, 100, y, { align: 'center', fontWeight: 'bold' })
    // y = addTextWithPageBreak(doc, `Valor Mínimo: R$ ${minValue.value.toLocaleString('pt-BR')}`, 100, y, { align: 'center', fontWeight: 'bold' })
    doc.setDrawColor(0)
    doc.rect(10, y - 18, 190, 10)
    // Campo 5: Solicitante
    y = addTextWithPageBreak(doc, 'Solicitante:', 10, y)
    const solicitanteLines = doc.splitTextToSize(solicitante.value, 180)
    y = addSplitTextWithPageBreak(doc, solicitanteLines, 10, y)
    doc.setFontSize(12)

    // Campo 6: Finalidade
    y = addTextWithPageBreak(doc, 'Finalidade da Avaliação:', 10, y)
    const finalidadeLines = doc.splitTextToSize(finalidade.value, 180)
    y = addSplitTextWithPageBreak(doc, finalidadeLines, 10, y)
    doc.setFontSize(12)

    // Campo 7: Descrição Imóvel
    y = addTextWithPageBreak(doc, 'Descrição do Imóvel:', 10, y)
    const descImovelLines = doc.splitTextToSize(descricaoImovel.value, 180)
    y = addSplitTextWithPageBreak(doc, descImovelLines, 10, y)
    doc.setFontSize(12)

    // Campo 8: Descrição Região
    y = addTextWithPageBreak(doc, 'Descrição da Região:', 10, y)
    const descRegiaoLines = doc.splitTextToSize(descricaoRegiao.value, 180)
    y = addSplitTextWithPageBreak(doc, descRegiaoLines, 10, y)
    doc.setFontSize(12)

    // Campo 9: Metodologia
    y = addTextWithPageBreak(doc, 'Metodologia da Avaliação:', 10, y)
    const metodoLines = doc.splitTextToSize(metodologia.value, 180)
    y = addSplitTextWithPageBreak(doc, metodoLines, 10, y)
    doc.setFontSize(12)

    // Campo 10: Conclusão
    y = addTextWithPageBreak(doc, 'Conclusão:', 10, y)
    const conclusaoLines = doc.splitTextToSize(conclusao.value, 180)
    y = addSplitTextWithPageBreak(doc, conclusaoLines, 10, y)
    doc.setFontSize(12)

    // Campo 11: Fotos
    y = addTextWithPageBreak(doc, 'Fotos Anexadas:', 10, y)
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
    /* border: 1px solid gray; */
    box-shadow: lightgray 2px 2px 5px;
    padding: 10px;
    border-radius: 5px;
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

.table {
    width: 100%;
    margin-bottom: 20px;
}
</style>