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
        
        <button @click="openModal">Abrir Pré-visualização A4</button>
        <Modal :isOpen="showModal" title="Pré-visualização da Página A4" @close="closeModal">
            <template #body>
            <!-- <PrintablePage
                :studyData="studyData"
            /> -->
            </template>
            <template #footer>
            <!-- <button @click="printPage">Imprimir</button> -->
            <!-- <button @click="closeModal">Fechar</button> -->
            <PrintablePage ref="pdfComponent" :studyData="studyData" />
            <button @click="gerarPDF">Gerar PDF</button>
            </template>
        </Modal>
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
import logoSrc from '@/assets/logo/1.png'

/** ALTERNATIVA COM MODAL E PAGINA A4 */
import Modal from './Modal.vue'
import PrintablePage from './PrintablePage.vue'
const showModal = ref(false);

const openModal = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const printPage = () => {
  // Foca na pré-visualização e imprime
  const printContent = document.querySelector('.sheet-outer'); // Seletor do PrintablePage
  if (printContent) {
    // Opção 1: Imprimir diretamente o conteúdo do modal
    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Impressão A4</title>');
    // Copie os estilos necessários (inclua o CSS do PrintablePage aqui)
    printWindow.document.write('<style>');
    // Cole os estilos CSS do PrintablePage aqui manualmente, ou importe via link se possível
    printWindow.document.write('/* Estilos do A4 aqui */');
    printWindow.document.write('</style></head><body>');
    printWindow.document.write(printContent.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
  } else {
    console.error('Conteúdo não encontrado');
  }
  // Opcionalmente, feche o modal após imprimir
  closeModal();
};
const pdfComponent = ref(null);

// ... seu código ...

const gerarPDF = () => {
  if (pdfComponent.value) {
    pdfComponent.value.exportToPDF();
  }
};
/** Fechando as tentativas com impressão modal A4 */

const studyData = {
  "proprietario": "Enzo Rodrigues e Laura",
  "endereco": "Rua Coronel Anibal Garcia Barão",
  "codigo": "135854",
  "atualizado": "25/06/2024",
  "agent": {
    "name": "Raissa Gracioli da Silva",
    "creci": "00000",
    "phone": "(55) 99995-0484",
    "email": "raissagracioli@remax.com.br",
    "photo": "https://www.shutterstock.com/image-photo/african-american-woman-braids-telemarketer-600nw-2196587531.jpg"
  },
  "footer": {
    "address": "Rua Silva Jardim, 1417, Centro, Santa Maria/RS | CNPJ: 18.268.552/0001-40",
    "phone": "(55) 9912-8466"
  },
  "property": {
    "endereco": "Rua Coronel Anibal Garcia Barão",
    "bairro": "Menino Jesus",
    "anoConstrucao": "1997",
    "areaUtil": "74m²",
    "dormitorios": 3,
    "suites": 0,
    "banheiros": 1,
    "vagas": 1,
    "infraestrutura": "Não tem",
    "portaria": "Não",
    "posicaoSolar": "Leste",
    "estado": "Bom",
    "semiMobiliado": "Não",
    "vistaPanoramica": "Não",
    "demandaRegiao": "Pouca demanda"
  },
  "samples": [
    {
      "location": "Centro - Rua Tuiuti",
      "endereco": "Rua Tuiuti",
      "area": "83m²",
      "dormitorios": 3,
      "preco": "320.000,00",
      "precoM2": "3.855,42"
    },
    {
      "location": "Centro - Rua Tuiuti",
      "endereco": "Rua Tuiuti",
      "area": "78m²",
      "dormitorios": 3,
      "preco": "245.000,00",
      "precoM2": "3.141,03"
    },
    {
      "location": "Cerrito - Rua Santinis",
      "endereco": "Rua Santinis",
      "area": "83m²",
      "dormitorios": 3,
      "preco": "270.000,00",
      "precoM2": "3.253,01"
    },
    {
      "location": "Centro - Rua Felipe De Oliveira",
      "endereco": "Rua Felipe De Oliveira",
      "area": "78m²",
      "dormitorios": 3,
      "preco": "275.000,00",
      "precoM2": "3.525,64"
    },
    {
      "location": "rosário - Rua Visconde De Pelotas",
      "endereco": "Rua Visconde De Pelotas",
      "area": "68m²",
      "dormitorios": 3,
      "preco": "289.000,00",
      "precoM2": "4.250,00"
    },
    {
      "location": "centro - Venâncio Aires",
      "endereco": "Venâncio Aires",
      "area": "80m²",
      "dormitorios": 3,
      "preco": "350.000,00",
      "precoM2": "4.375,00"
    }
  ],
  "average": {
    "area": "78",
    "preco": "291.500,00",
    "precoM2": "3.733,35"
  },
  "results": {
    "improvavel": "234.768,92",
    "mercado": "218.335,09",
    "competitivo": "199.553,58"
  }
}


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
const solicitante = ref('') //ref('')
const finalidade = ref('') //ref('')
const descricaoImovel = ref('') //ref('')
const descricaoRegiao = ref('') //ref('')
const metodologia = ref('') //ref('')
const conclusao = ref('') //ref('')
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
    if (y > 260) {
        doc.addPage()
        y = 30 // Ajustado para deixar espaço para o cabeçalho
    }
    doc.text(text, x, y, options)
    return y + (options.lineHeight || 10)
}

// Função auxiliar para adicionar linhas de texto com quebra de página
function addSplitTextWithPageBreak(doc, lines, x, y, fontSize = 10, lineHeight = 7) {
    doc.setFontSize(fontSize)
    lines.forEach(line => {
        if (y > 260) {
            doc.addPage()
            y = 30 // Ajustado para deixar espaço para o cabeçalho
        }
        doc.text(line, x, y)
        y += lineHeight
    })
    return y + 5 // Espaço extra após o bloco
}

// Função auxiliar para adicionar imagem com quebra de página
async function addImageWithPageBreak(doc, base64, format, x, y, width, height) {
    if (y + height > 260) {
        doc.addPage()
        y = 30 // Ajustado para deixar espaço para o cabeçalho
    }
    doc.addImage(base64, format, x, y, width, height)
    return y + height + 10 // Espaço extra
}

// Função auxiliar para desenhar um card estilizado horizontal
function drawStyledCard(doc, title, value, x, y, width = 190, height = 20) {
    if (y + height > 200) {
        doc.addPage()
        y = 30 // Ajustado para deixar espaço para o cabeçalho
    }

    // Fundo do card (#02244a)
    doc.setFillColor(2, 36, 74) // RGB para #02244a
    doc.rect(x, y, width, height, 'F')

    // Borda com destaque (#e2ae23)
    doc.setDrawColor(226, 174, 35) // RGB para #e2ae23
    doc.setLineWidth(1)
    doc.rect(x, y, width, height)

    // Texto do título (branco, negrito)
    doc.setFontSize(14)
    doc.setTextColor(255, 255, 255) // Branco
    doc.setFont('helvetica', 'bold')
    doc.text(title, x + 10, y + (height / 2) + 2, { align: 'left' }) // Centralizado verticalmente

    // Texto do valor (branco, negrito, alinhado à direita)
    doc.text(value, x + width - 10, y + (height / 2) + 2, { align: 'right' })

    // Resetar cores
    doc.setTextColor(0, 0, 0) // Preto padrão
    doc.setDrawColor(0)
    doc.setLineWidth(0.2)
    doc.setFont('helvetica', 'normal')

    return y + height + 10 // Espaço extra após o card
}

// Função auxiliar para calcular dimensões da imagem
async function getImageDimensions(base64) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.src = base64;
        img.onload = () => resolve({ width: img.width, height: img.height });
        img.onerror = reject;
    });
}

// Exportar para PDF
async function exportToPDF() {
    const doc = new jsPDF({ unit: 'mm' })
    let y = 30 // Iniciar conteúdo após o espaço para cabeçalho

    // const logoBase64 = await getBase64(logoSrc)
    const logoBase64 = logoSrc
    const footerText = "Avantor Negócios Imobiliários Ltda. * Creci 24.707J * Rua Silva Jardim, 1417, Centro, Santa Maria/RS | R. 3300, nº 341, Sala 12, Balneário Camboriú/SC CNPJ: 18.268.552/0001-40"

    // Título
    doc.setFontSize(18)
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Relatório de Avaliação de Imóvel', 10, y, { lineHeight: 15 })
    doc.setFont('helvetica', 'normal')

    // Data
    doc.setFontSize(12)
    y = addTextWithPageBreak(doc, `Data: ${new Date().toLocaleDateString('pt-BR')}`, 10, y)

    // Bairros Pesquisados
    doc.setFont('helvetica', 'bold')
    // y = addTextWithPageBreak(doc, `Bairros Pesquisados: ${props.bairros.join(', ')}`, 10, y)
    doc.setFont('helvetica', 'normal')
    const bairroslistadosaqui = doc.splitTextToSize(props.bairros.join(', '), 200)
    y = addSplitTextWithPageBreak(doc, bairroslistadosaqui, 10, y)
    doc.setFontSize(12)
    doc.setFont('helvetica', 'normal')
    /**
     * // Campo 5: Solicitante
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Solicitante:', 10, y)
    doc.setFont('helvetica', 'normal')
    const solicitanteLines = doc.splitTextToSize(solicitante.value, 180)
    y = addSplitTextWithPageBreak(doc, solicitanteLines, 10, y)
    doc.setFontSize(12)
     */

    // Mapa
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Mapa da Região:', 10, y)
    doc.setFont('helvetica', 'normal')
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
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Imóveis Comparáveis:', 10, y)
    doc.setFont('helvetica', 'normal')
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
        styles: { fontSize: 8 },
        margin: { top: 30, bottom: 30, left: 10, right: 10 },
        pageBreak: 'auto'
    })
    y = doc.lastAutoTable.finalY + 10

    // Campo 1: Fachada
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Fachada do Imóvel:', 10, y)
    doc.setFont('helvetica', 'normal')
    if (fachadaImage.value) {
        try {
            const base64 = await getBase64(fachadaFile.value || fachadaImage.value)
            const { width: naturalWidth, height: naturalHeight } = await getImageDimensions(base64)
            const pdfWidth = 190
            const pdfHeight = (naturalHeight / naturalWidth) * pdfWidth
            y = await addImageWithPageBreak(doc, base64, 'JPEG', 10, y, pdfWidth, pdfHeight)
        } catch (error) {
            console.error('Erro ao adicionar imagem da fachada:', error)
            y = addTextWithPageBreak(doc, '(Imagem não pôde ser carregada)', 10, y)
        }
    } else {
        y = addTextWithPageBreak(doc, 'Nenhuma imagem fornecida', 10, y)
    }

    // Card estilizado para Ajuste do Valor Final
    y = drawStyledCard(doc, 'Ajuste do Valor Final:', `R$ ${adjustedValue.value.toLocaleString('pt-BR')}`, 10, y, 190, 25)

    // Card estilizado para Intervalos Máximo e Mínimo (combinado em um card horizontal)
    y = drawStyledCard(doc, 'Intervalo de Valores:', `Máximo: R$ ${maxValue.value.toLocaleString('pt-BR')} | Mínimo: R$ ${minValue.value.toLocaleString('pt-BR')}`, 10, y, 190, 25)

    // Campo 5: Solicitante
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Solicitante:', 10, y)
    doc.setFont('helvetica', 'normal')
    const solicitanteLines = doc.splitTextToSize(solicitante.value, 180)
    y = addSplitTextWithPageBreak(doc, solicitanteLines, 10, y)
    doc.setFontSize(12)

    // Campo 6: Finalidade
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Finalidade da Avaliação:', 10, y)
    doc.setFont('helvetica', 'normal')
    const finalidadeLines = doc.splitTextToSize(finalidade.value, 180)
    y = addSplitTextWithPageBreak(doc, finalidadeLines, 10, y)
    doc.setFontSize(12)

    // Campo 7: Descrição Imóvel
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Descrição do Imóvel:', 10, y)
    doc.setFont('helvetica', 'normal')
    const descImovelLines = doc.splitTextToSize(descricaoImovel.value, 180)
    y = addSplitTextWithPageBreak(doc, descImovelLines, 10, y)
    doc.setFontSize(12)

    // Campo 8: Descrição Região
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Descrição da Região:', 10, y)
    doc.setFont('helvetica', 'normal')
    const descRegiaoLines = doc.splitTextToSize(descricaoRegiao.value, 180)
    y = addSplitTextWithPageBreak(doc, descRegiaoLines, 10, y)
    doc.setFontSize(12)

    // Campo 9: Metodologia
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Metodologia da Avaliação:', 10, y)
    doc.setFont('helvetica', 'normal')
    const metodoLines = doc.splitTextToSize(metodologia.value, 180)
    y = addSplitTextWithPageBreak(doc, metodoLines, 10, y)
    doc.setFontSize(12)

    // Campo 10: Conclusão
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Conclusão:', 10, y)
    doc.setFont('helvetica', 'normal')
    const conclusaoLines = doc.splitTextToSize(conclusao.value, 180)
    y = addSplitTextWithPageBreak(doc, conclusaoLines, 10, y)
    doc.setFontSize(12)

    // Campo 11: Fotos
    doc.setFont('helvetica', 'bold')
    y = addTextWithPageBreak(doc, 'Fotos Anexadas:', 10, y)
    doc.setFont('helvetica', 'normal')
    for (let i = 0; i < fotosFiles.value.length; i++) {
        try {
            const base64 = await getBase64(fotosFiles.value[i])
            const { width: naturalWidth, height: naturalHeight } = await getImageDimensions(base64)
            const pdfWidth = 190
            const pdfHeight = (naturalHeight / naturalWidth) * pdfWidth
            y = await addImageWithPageBreak(doc, base64, 'JPEG', 10, y, pdfWidth, pdfHeight)
        } catch (error) {
            console.error(`Erro ao adicionar foto ${i + 1}:`, error)
            y = addTextWithPageBreak(doc, `(Foto ${i + 1} não pôde ser carregada)`, 10, y)
        }
    }

    // Adicionar cabeçalho e rodapé em todas as páginas
    const totalPages = doc.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
        doc.setPage(i);

        // Cabeçalho: Logo sem fundo adicional (removido o retângulo branco para testar)
        doc.addImage(logoBase64, 'PNG', 10, 5, 50, 20); // Ajuste as dimensões conforme o tamanho real do logo

        // Rodapé
        doc.setFontSize(8);
        doc.setTextColor(100);
        const footerLines = doc.splitTextToSize(footerText, 190);
        let footerY = doc.internal.pageSize.height - (footerLines.length * 5) - 10; // Ajustado para melhor posicionamento (mais espaço na parte inferior)
        footerLines.forEach((line, index) => {
            doc.text(line, 10, footerY + index * 5);
        });
        doc.setTextColor(0);
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