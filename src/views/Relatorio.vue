<template>
    <div class="avaliacao-container">
        <h4>Avaliação de Imóvel</h4>

        <h5><strong>Bairros Pesquisados:</strong> {{ props.bairros.join(', ') }}</h5>
        <hr>
        <!-- Mapa com círculo ao redor do ponto central -->
        <div class="map-section" v-show="false">
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

        <h4>Imóveis Comparáveis</h4>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in imoveis" :key="index" :class="{ 'table-success': item.manual }">
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
                    <td>
                        <button
                            v-if="item.manual"
                            type="button"
                            class="btn btn-sm btn-outline-danger py-0 px-1"
                            @click="removerImovel(index)"
                            title="Remover"
                        >✕</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Adicionar imóvel manualmente -->
        <div class="mb-2">
            <button
                type="button"
                class="btn btn-sm btn-outline-success"
                @click="showNovoImovel = !showNovoImovel"
            >
                <font-awesome-icon icon="plus" /> Adicionar imóvel manualmente
            </button>
        </div>

        <div v-if="showNovoImovel" class="card card-body mb-4 border-success bg-light">
            <h6 class="mb-3">Novo imóvel comparável</h6>
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label small mb-0">Imobiliária / Fonte</label>
                    <input type="text" v-model="novoImovel.imobiliaria" class="form-control form-control-sm" placeholder="Ex: ZAP Imóveis" />
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-0">Cidade</label>
                    <input type="text" v-model="novoImovel.cidade" class="form-control form-control-sm" placeholder="Ex: Santa Maria" />
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-0">Bairro</label>
                    <input type="text" v-model="novoImovel.bairro" class="form-control form-control-sm" placeholder="Ex: Centro" />
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-0">Negócio</label>
                    <select v-model="novoImovel.negocio" class="form-select form-select-sm">
                        <option value="Venda">Venda</option>
                        <option value="Locação">Locação</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-0">Valor (R$) *</label>
                    <input type="number" v-model.number="novoImovel.valor" class="form-control form-control-sm" placeholder="450000" min="0" />
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-0">Área (m²)</label>
                    <input type="number" v-model.number="novoImovel.area" class="form-control form-control-sm" placeholder="85" min="0" />
                </div>
                <div class="col-md-1">
                    <label class="form-label small mb-0">Dorm.</label>
                    <input type="number" v-model.number="novoImovel.dormitorios" class="form-control form-control-sm" placeholder="3" min="0" />
                </div>
                <div class="col-md-1">
                    <label class="form-label small mb-0">Banh.</label>
                    <input type="number" v-model.number="novoImovel.banheiros" class="form-control form-control-sm" placeholder="2" min="0" />
                </div>
                <div class="col-md-1">
                    <label class="form-label small mb-0">Gar.</label>
                    <input type="number" v-model.number="novoImovel.garagens" class="form-control form-control-sm" placeholder="1" min="0" />
                </div>
            </div>
            <div class="mt-3 d-flex gap-2">
                <button type="button" class="btn btn-success btn-sm" @click="salvarNovoImovel">Adicionar à lista</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" @click="showNovoImovel = false">Cancelar</button>
            </div>
        </div>

        <!-- Formulário de Avaliação -->
        <form class="avaliacao-form">
            <!-- Campo 1: Fachada do Imóvel -->
            <!-- <div class="field">
                <label>Fachada do Imóvel</label>
                <div class="streetview-controls">
                    <input type="text" v-model="apiKey" placeholder="Insira sua API Key do Google Maps" />
                    <button @click.prevent="fetchStreetView">Buscar do Street View</button>
                </div>
                <input type="file" accept="image/*" @change="handleFachadaUpload" />
                <img v-if="fachadaImage" :src="fachadaImage" alt="Fachada do Imóvel" class="preview-image" />
            </div> -->

            <!-- Campo 2: Ajuste do Valor Final -->
            <div class="field">
                <label>Valor de Mercado (R$)</label>
                <input type="number" v-model="adjustedValue" />
            </div>

            <!-- Campos 3 e 4: Valores Máximo e Mínimo -->
            <div class="field-group">
                <div class="field">
                    <label>Valor Improvável<br>(% em relação ao valor médio)</label>
                    <input type="number" v-model="valorImprovavel" min="0" step="0.1" />
                </div>
                <div class="field">
                    <label>Valor de Mercado<br>(% em relação ao valor improvável)</label>
                    <input type="number" v-model="valorMercado" min="0" step="0.1" />
                </div>
                <div class="field">
                    <label>Valor Improvável<br>(% em relação ao valor improvável)</label>
                    <input type="number" v-model="valorCompetitivo" min="0" step="0.1" />
                </div>
            </div>
            <div class="field-group">
                <div class="field">
                    <label>Valor Improvável (R$)</label>
                    <label>R$ {{ Math.round(vImprovavel).toLocaleString() }}</label>
                </div>
                <div class="field">
                    <label>Valor de Mercado (R$)</label>
                    <label>R$ {{ Math.round(vMercado).toLocaleString() }}</label>
                </div>
                <div class="field">
                    <label>Valor Competitivo (R$)</label>
                    <label>R$ {{ Math.round(vCompetitivo).toLocaleString() }}</label>
                </div>
            </div>

            <!-- Campo 5: Solicitante -->
            <div class="field">
                <label>Solicitante</label>
                <!-- <textarea v-model="solicitante" rows="3"></textarea> -->
                 <!-- <QuillEditor
                    v-model:content="solicitante"
                    style="background-color: white;"
                    content-type="html"
                    theme="snow"
                    :toolbar="[
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['clean']
                    ]"
                /> -->
                <input type="text" v-model="solicitante">
            </div>

            <!-- Campo 6: Finalidade da Avaliação -->
            <div class="field">
                <label>Principais dados do Imóvel</label>
                <!-- <textarea v-model="finalidade" rows="3"></textarea> -->
                <QuillEditor
                    v-model:content="finalidade"
                    content-type="html"
                    style="background-color: white;"
                    theme="snow"
                    :toolbar="[
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['clean']
                    ]"
                />
            </div>

            <!-- Campo 7: Descrição do Imóvel -->
            <div class="field">
                <label>O que identifiquei no seu imóvel</label>
                 <QuillEditor
                    v-model:content="descricaoImovel"
                    content-type="html"
                    style="background-color: white;"
                    theme="snow"
                    :toolbar="[
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['clean']
                    ]"
                />
            </div>

            <!-- Campo 8: Metodologia Aplicada -->
            <div class="field">
                <label>Metodologia Aplicada</label>
                <QuillEditor
                    v-model:content="metodologiaAplicada"
                    content-type="html"
                    style="background-color: white;"
                    theme="snow"
                    :toolbar="[
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['clean']
                    ]"
                />
            </div>

            <!-- Campo 9: Dados do Imóvel -->
            <div class="field">
                <label>Dados do Imóvel</label>
                <small class="text-muted d-block mb-2">Marque os campos para exibir no relatório PDF.</small>
                <div class="table-responsive">
                    <table class="table table-sm table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:36px" class="text-center">PDF</th>
                                <th>Campo</th>
                                <th>Valor</th>
                                <th style="width:36px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(campo, idx) in dadosImovelEstruturado" :key="idx">
                                <td class="text-center">
                                    <input type="checkbox" v-model="campo.mostrar" class="form-check-input mt-0" />
                                </td>
                                <td>
                                    <input
                                        type="text"
                                        v-model="campo.label"
                                        class="form-control form-control-sm"
                                        :disabled="campo.fixo"
                                        :placeholder="campo.fixo ? campo.label : 'Nome do campo'"
                                    />
                                </td>
                                <td>
                                    <input
                                        type="text"
                                        v-model="campo.value"
                                        class="form-control form-control-sm"
                                        placeholder="Valor"
                                    />
                                </td>
                                <td>
                                    <button
                                        v-if="!campo.fixo"
                                        type="button"
                                        class="btn btn-sm btn-outline-danger py-0 px-1"
                                        @click="dadosImovelEstruturado.splice(idx, 1)"
                                        title="Remover campo"
                                    >✕</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button
                    type="button"
                    class="btn btn-sm btn-outline-secondary mt-2"
                    @click="adicionarCampoImovel"
                >+ Adicionar campo</button>
            </div>

            <!-- Avatar do Avaliador -->
            <div class="field">
                <label>Corretor Avaliador</label>
                <div class="field-group">
                    <div class="field">
                        <label>Nome</label>
                        <input type="text" v-model="corretor.nome" placeholder="Nome do corretor avaliador" />

                        <label>Email</label>
                        <input type="email" v-model="corretor.email" placeholder="email@dominio.com" />

                        <label>Telefone</label>
                        <input type="text" v-model="corretor.celular" placeholder="(00) 00000-0000" />

                        <label>Foto (URL)</label>
                        <input type="text" v-model="corretor.foto" placeholder="https://..." />

                        <label>Ou enviar foto</label>
                        <input type="file" accept="image/*" @change="handleCorretorFotoUpload" />
                    </div>
                    <div class="field">

                        <!-- Avatar do corretor, pegando de https://api.jetimob.com/webservice/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/corretores pelo email -->
                        <img
                        :src="corretor.foto || retornaCorretorAvatar(corretor.email)"
                        @error="(e) => e.target.src = 'assets/fotos-corretores/foto-perfil.jpg'"
                        alt="Avatar do Corretor"
                        class="preview-image small mt-2"
                    />
                </div>
                <!-- <div class="field">
                    {{ corretor }}
                    <img :src="corretor.foto">
                </div> -->
                </div>
            </div>

            <!-- Campo 8: Descrição da Região -->
            <!-- <div class="field">
                <label>Descrição da Região</label>
                 <QuillEditor
                    v-model:content="descricaoRegiao"
                    content-type="html"
                    style="background-color: white;"
                    theme="snow"
                    :toolbar="[
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['clean']
                    ]"
                />
            </div> -->

            <!-- Campo 9: Metodologia da Avaliação -->
            <!-- <div class="field">
                <label>Metodologia da Avaliação</label>
                 <QuillEditor
                    v-model:content="metodologia"
                    content-type="html"
                    style="background-color: white;"
                    theme="snow"
                    :toolbar="[
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['clean']
                    ]"
                />
            </div> -->

            <!-- Campo 10: Conclusão -->
            <!-- <div class="field">
                <label>Conclusão</label>
                    <QuillEditor
                        v-model:content="conclusao"
                        content-type="html"
                        style="background-color: white;"
                        theme="snow"
                        :toolbar="[
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['clean']
                        ]"
                    />
            </div> -->

            <!-- Campo 11: Anexar Fotos -->
            <!-- <div class="field">
                <label>Anexar Fotos</label>
                <input type="file" accept="image/*" multiple @change="handleFotosUpload" />
                <div class="photos-preview">
                    <img v-for="(photo, index) in fotosPreviews" :key="index" :src="photo" alt="Foto anexada" class="preview-image small" />
                </div>
            </div> -->

            <!-- Botão de Exportar para PDF -->
            <!-- <button class="export-button" @click.prevent="exportToPDF">Exportar para PDF</button> -->
        </form>
        
        <button @click="openModal" class="btn btn-primary my-3">
            <font-awesome-icon icon="gauge" class="fa-1xl mx-1" /> Abrir Pré-visualização A4
        </button>
        <Modal :isOpen="showModal" title="Pré-visualização da Página A4" @close="closeModal">
            <template #body>
                <!-- Uma div com scroll intrno pra ler só o relatorio -->
                 <div style="max-height: 80vh; overflow-y: auto; padding-right: 10px;">
                    <div ref="pdfComponent" style="">
                        <!-- {{ imoveis }} -->
                        <Relatoriov2
                            :mediana="adjustedValue"
                            :imoveis="imoveis"
                            :bairros="props.bairros"
                            :cidade="props.cidade"
                            :vImprovavel="vImprovavel"
                            :vMercado="vMercado"
                            :vCompetitivo="vCompetitivo"
                            :corretor="corretor"
                            :cliente="{ nome: solicitante }"
                            :dadosImovel="finalidade"
                            :identifiqueiNoImovel="descricaoImovel"
                            :metodologiaAplicada="metodologiaAplicada"
                            :dadosImovelEstruturado="dadosImovelEstruturado"
                            :fotocorretor="corretor.foto || retornaCorretorAvatar(corretor.email)"
                        />
                    </div>
                </div>
            </template>
            <template #footer>
            <!-- <button @click="printPage">Imprimir</button> -->
            <button @click="closeModal" class="w-25 my-3 btn btn-warning">Fechar</button>
            </template>
        </Modal>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted, onUnmounted } from 'vue'
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet'
// import { required } from 'vuelidate/lib/validators'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import html2canvas from 'html2canvas'
import bairrosCoords from '@/assets/jsons/bairrosltlg.json'
import corretoresData from '@/assets/jsons/corretores.json'
import logoSrc from '@/assets/logo/1.png'

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import Relatoriov2 from './Relatoriov2.vue'

/** ALTERNATIVA COM MODAL E PAGINA A4 */
import Modal from './Modal.vue'
import PrintablePage from './PrintablePage.vue'
import { icon } from 'leaflet'
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

const props = defineProps({
    mediana: { type: Number, required: true },
    imoveis: { type: Array, default: () => [] },
    bairros: { type: Array, default: () => [] },
    cidade: { type: String, default: 'Santa Maria' },
    fotocorretor: String
})

const fotocorretor = props.fotocorretor

const dadoscorretor = ref('')
const corretorlogado = ref({})
const corretor = ref({
    nome: '',
    email: '',
    celular: '',
    foto: ''
})

onMounted(() => {
  if (localStorage.getItem('authUser')) {
    dadoscorretor.value = localStorage.getItem('authUser');
    corretorlogado.value = JSON.parse(dadoscorretor.value);
    console.log(corretorlogado.value)
    corretor.value = {
        nome: corretorlogado.value.nome,
        email: corretorlogado.value.email,
        celular: corretorlogado.value.celular,
        foto: fotocorretor
    }
    console.log ("corretor.value")
    console.log (props.fotocorretor)
  }
})

function handleCorretorFotoUpload(event) {
    const file = event.target.files?.[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        corretor.value.foto = e.target?.result || '';
    };
    reader.readAsDataURL(file);
}

//vamos limitar os imóveis a 10 para evitar lentidão
const imoveis = ref(props.imoveis.slice(0, 10))

// Atualiza a lista quando a prop mudar (ex: voltar e refiltrar)
watch(() => props.imoveis, (newVal) => {
    imoveis.value = newVal.slice(0, 10)
})

// Cadastro manual
const showNovoImovel = ref(false)
const novoImovelBase = () => ({
    imobiliaria: '', bairro: '', negocio: 'Venda', finalidade: 'Venda',
    valor: null, area: 0, dormitorios: null, banheiros: null, garagens: null,
    cidade: '', mobiliado: 0, manual: true,
})
const novoImovel = reactive(novoImovelBase())

const parseValorNumero = (valor) => {
    if (typeof valor === 'number') return valor
    if (typeof valor !== 'string') return NaN
    const normalizado = valor
        .trim()
        .replace(/R\$/gi, '')
        .replace(/\s/g, '')
        .replace(/\./g, '')
        .replace(',', '.')
    return parseFloat(normalizado)
}

const calcularMediana = (lista) => {
    if (!lista.length) return 0
    const ordenados = [...lista].sort((a, b) => a - b)
    const meio = Math.floor(ordenados.length / 2)
    return ordenados.length % 2 === 0
        ? (ordenados[meio - 1] + ordenados[meio]) / 2
        : ordenados[meio]
}

const calcularMedianaLocal = () => {
    const valoresBase = imoveis.value
        .map(i => parseValorNumero(i.valor))
        .filter(v => !isNaN(v) && v > 0)

    if (valoresBase.length === 0) return

    // Alguns registros podem vir em escalas diferentes (ex: centavos).
    // Testamos escalas comuns e escolhemos a mais próxima da mediana atual.
    const referencia = Number(adjustedValue.value) || Number(props.mediana) || 0
    const escalas = [1, 0.1, 0.01]

    const melhorEscala = escalas.reduce((melhor, escala) => {
        const medianaEscalada = calcularMediana(valoresBase.map(v => v * escala))
        const distancia = Math.abs(medianaEscalada - referencia)
        return distancia < melhor.distancia ? { escala, distancia } : melhor
    }, { escala: 1, distancia: Number.POSITIVE_INFINITY }).escala

    const medianaFinal = calcularMediana(valoresBase.map(v => v * melhorEscala))
    adjustedValue.value = medianaFinal
}

const salvarNovoImovel = () => {
    if (!novoImovel.valor || novoImovel.valor <= 0) {
        alert('Informe um valor válido para o imóvel.')
        return
    }
    imoveis.value.push({ ...novoImovel })
    calcularMedianaLocal()
    Object.assign(novoImovel, novoImovelBase())
    showNovoImovel.value = false
}

const removerImovel = (index) => {
    imoveis.value.splice(index, 1)
    calcularMedianaLocal()
}

// Ref para o mapa
const mapRef = ref(null)
// Loren Ipsum for testing
const loremIpsum = `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.`
// Estados
const adjustedValue = ref(props.mediana)
const valorImprovavel = ref(12) // Valor da Mediana menos 12%
const valorMercado = ref(7) // Valor da Mediana menos 12%
const valorCompetitivo = ref(15) // Valor da Mediana menos 12%
const solicitante = ref('') //ref('')
const finalidade = ref('') //ref('')
const descricaoImovel = ref('') //ref('')
const descricaoRegiao = ref('') //ref('')
const metodologia = ref('') //ref('')
const conclusao = ref('') //ref('')
const metodologiaAplicada = ref('')
const dadosImovelEstruturado = ref([
    { label: 'Tipo',                  value: '', mostrar: true,  fixo: true },
    { label: 'Subtipo',               value: '', mostrar: true,  fixo: true },
    { label: 'Valor (R$)',            value: '', mostrar: true,  fixo: true },
    { label: 'Dormitórios / Cômodos', value: '', mostrar: true,  fixo: true },
    { label: 'Garagens',              value: '', mostrar: true,  fixo: true },
    { label: 'Banheiros',             value: '', mostrar: true,  fixo: true },
    { label: 'Área Privativa (m²)',   value: '', mostrar: true,  fixo: true },
    { label: 'Área Total (m²)',       value: '', mostrar: true,  fixo: true },
    { label: 'Comodidades',           value: '', mostrar: true,  fixo: true },
    { label: 'Condomínio',            value: '', mostrar: true,  fixo: true },
])

function adicionarCampoImovel() {
    dadosImovelEstruturado.value.push({ label: '', value: '', mostrar: true, fixo: false })
}
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

// Computeds para valor Improvável
const vImprovavel = computed(() => adjustedValue.value * (1 - valorImprovavel.value / 100))
// Valor de mercado = vImprovavel - 7%
const vMercado = computed(() => vImprovavel.value * (1 - valorMercado.value/100))
// Valor competitivo = vImprovavel - 15%
const vCompetitivo = computed(() => vImprovavel.value * (1 - valorCompetitivo.value/100))

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

const fotoquevaiprorelatorio = retornaCorretorAvatar(corretor.value.email);

function retornaCorretorAvatar(email) {
    const emailHash = email;
    /** precisamos ler o json, buscar pelo email, e retornar o avatar */
    if (props.fotocorretor) {
        return props.fotocorretor;
    } else {
        try {
            // Validação do email de entrada
            if (!email) {
                return `https://www.gravatar.com/avatar/${emailHash}?d=identicon`;
            }
            
            // pega o avatar do corretor pelo email no json local
            const corretoresArray = Array.isArray(corretoresData) ? corretoresData : corretoresData.corretores;
            const corretorEncontrado = corretoresArray.find(corretor => 
                corretor.email && corretor.email.trim().toLowerCase() === email.trim().toLowerCase()
            );
            if (corretorEncontrado && corretorEncontrado.avatar) {
                return corretorEncontrado.avatar;
            } else {
                return `https://www.gravatar.com/avatar/${emailHash}?d=identicon`;
            }
        } catch (error) {
            console.error('Erro ao carregar o JSON de corretores:', error);
            return `https://www.gravatar.com/avatar/${emailHash}?d=identicon`;
        }
    }
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