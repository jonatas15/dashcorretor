<template>
  <!-- BOTÃO -->
  <button class="print-btn" @click="gerarPDF">Imprimir PDF</button>

  <!-- ÁREA IMPRIMÍVEL -->
  <div
    id="print-area"
  >
    <div class="page-a4">
      <!-- :style="{ backgroundImage: `url(${pagina.banner})` }" -->
      <div class="header"></div>

      <div class="content">
        <div class="left">
          <h1>{{ pagina.titulo }}</h1>
        </div>

        <div class="right">
          <div class="avatar">
            <img :src="pagina.corretor.foto" />
          </div>

          <div class="broker-info">
            <span class="label">ESTUDO REALIZADO POR:</span>
            <strong>{{ pagina.corretor.nome }}</strong>
            <h5 class="identificacao-label">{{ pagina.corretor.telefone }}</h5>
            <h5 class="identificacao-label">{{ pagina.corretor.email }}</h5>
          </div>

          <div class="logo">
            <img :src="pagina.logo" />
          </div>
        </div>
      </div>
    </div>
    <div class="page-a4 page-analise no-background">
      <!-- HEADER SIMPLES -->
      <div class="page-header">
        <img src="@/assets/logo.png" class="logo-top" />
        <span class="header-title">
          ESTUDO ESTRATÉGICO / PLANO DE DIVULGAÇÃO
        </span>
      </div>

      <hr class="divider" />

      <!-- CONTEÚDO -->
      <div class="page-body">
        <h2>OLÁ, ENZO RODRIGUES E LAURA.</h2>

        <p>
          Entender a posição do seu imóvel no mercado é o primeiro passo para
          realizar uma venda com qualidade e segurança. Para isso, realizamos um
          estudo com base nas características do seu imóvel e nas ofertas de
          imóveis similares na região.
        </p>

        <p>
          O objetivo principal deste estudo é identificar o valor correto de
          venda. Esse valor é o que posiciona o seu imóvel com destaque no
          mercado e evita que ele acabe ajudando a vender os imóveis
          concorrentes.
        </p>

        <hr class="section-divider" />

        <h3>RELAÇÃO ENTRE PREÇO E VELOCIDADE DE VENDA</h3>

        <p>
          A velocidade de venda de seu imóvel está diretamente relacionada à
          precificação correta. Nosso histórico de vendas mostra que imóveis
          anunciados acima do preço de mercado tendem a ter um processo de venda
          mais lento.
        </p>

        <p>
          Além disso, muitas vezes o valor final negociado acaba sendo inferior
          ao valor real de mercado, o que resulta em perda de patrimônio.
        </p>

        <!-- GRÁFICO SIMPLIFICADO -->
        <div class="containerx">
          <div class="timeline">
            <span class="left-label">MENOS TEMPO DE VENDA</span>
            <div class="arrow"></div>
            <span class="right-label">MAIS TEMPO DE VENDA</span>
          </div>
          <div class="bar">
            <div class="segment blue">PREÇO DE MERCADO</div>
            <div class="segment yellow">+10%</div>
            <div class="segment orange">+20%</div>
            <div class="segment red">+30%</div>
          </div>
        </div>

        <h3>VANTAGENS DE ANUNCIAR O IMÓVEL PELO PREÇO CORRETO:</h3>

        <ol class="advantages">
          <li>Venda dentro de um prazo mais curto</li>
          <li>Menos inconvenientes ao longo do processo</li>
          <li>Mais clientes interessados e maior número de visitas</li>
          <li>Corretores mais motivados a apresentar o imóvel</li>
          <li>Propostas mais assertivas</li>
          <li>Menor risco de perda financeira</li>
          <li>Seu imóvel representado por apenas um corretor</li>
        </ol>
      </div>

      <!-- RODAPÉ -->
      <!-- <div class="page-footer">
    <span>www.avantorimoveis.com.br</span>
  </div> -->
    </div>
    <div class="page-a4 page-analise page-marketing no-background">
      <!-- HEADER -->
      <div class="page-header">
        <img src="/logo.png" class="logo-top" />
        <span class="header-title">
          Estudo de mercado e plano de marketing
        </span>
      </div>

      <hr class="divider" />

      <!-- TÍTULO -->
      <h2>Plano de marketing personalizado</h2>

      <p class="intro">
        Desenvolvemos para cada imóvel um plano de marketing especial, que vai
        muito além da simples publicação de ofertas em um site. Vamos entender,
        preparar e divulgar seu imóvel nos canais certos para as pessoas certas.
      </p>

      <hr class="section-divider" />

      <!-- LINHAS DE AÇÕES -->

      <hr class="row-divider" />

      <div class="marketing-row">
        <ul>
          <li>Fotos profissionais</li>
          <li>Vídeo do imóvel</li>
        </ul>

        <div class="icons">
          <img src="/icons/foto.png" />
          <img src="/icons/video.png" />
        </div>
      </div>

      <hr class="row-divider" />

      <div class="marketing-row">
        <ul>
          <li>Divulgação no portal VivaReal</li>
          <li>Divulgação no portal Zap</li>
          <li>Divulgação no portal OLX</li>
        </ul>

        <div class="icons">
          <img src="/icons/vivareal.png" />
          <img src="/icons/zap.png" />
          <img src="/icons/olx.png" />
        </div>
      </div>

      <hr class="row-divider" />

      <div class="marketing-row">
        <ul>
          <li>Email marketing para clientes compradores</li>
          <li>Email marketing para corretores parceiros</li>
          <li>Email marketing para imobiliárias parceiras</li>
        </ul>

        <div class="icons">
          <img src="/icons/email.png" />
          <img src="/icons/email.png" />
          <img src="/icons/email.png" />
        </div>
      </div>

      <hr class="row-divider" />

      <div class="marketing-row">
        <ul>
          <li>Divulgação no Facebook</li>
          <li>Divulgação no Instagram</li>
          <li>Divulgação no Google</li>
        </ul>

        <div class="icons">
          <img src="/icons/facebook.png" />
          <img src="/icons/instagram.png" />
          <img src="/icons/google.png" />
        </div>
      </div>

      <hr class="row-divider" />

      <div class="marketing-row">
        <ul>
          <li>Visita com corretores parceiros no imóvel</li>
          <li>Feedback sobre o andamento das ações e resultados</li>
        </ul>

        <div class="icons">
          <img src="/icons/visita.png" />
          <img src="/icons/feedback.png" />
        </div>
      </div>

      <!-- RODAPÉ -->
      <!-- <div class="page-footer">
        <span>www.avantorimoveis.com.br</span>
      </div> -->
    </div>
    <div class="page-a4 page-analise no-background page-dados">
      <!-- HEADER -->
      <div class="page-header">
        <img src="/logo.png" class="logo-top" />
        <span class="header-title">
          ESTUDO ESTRATÉGICO / PLANO DE DIVULGAÇÃO
        </span>
      </div>

      <hr class="divider" />

      <!-- DADOS DO IMÓVEL -->
      <h2>DADOS PRINCIPAIS DO SEU IMÓVEL:</h2>
      <h3>CARACTERÍSTICAS DO IMÓVEL</h3>

      <ul class="data-list">
        <li v-for="(item, index) in caracteristicas" :key="index">
          <strong>{{ item.label }}:</strong> {{ item.value }}
        </li>
      </ul>

      <hr class="section-divider" />

      <!-- ANÁLISE -->
      <h2>O QUE IDENTIFIQUEI NO SEU IMÓVEL:</h2>
      <h3>METODOLOGIA APLICADA</h3>

      <p class="text">
        {{ metodologiaTexto }}
      </p>

      <ul class="data-list">
        <li v-for="(item, index) in criteriosComparacao" :key="index">
          {{ item }}
        </li>
      </ul>

      <p class="text">
        {{ conclusaoTexto }}
      </p>

      <!-- RODAPÉ -->
      <!-- <div class="page-footer">
        <span>{{ rodape }}</span>
      </div> -->
    </div>
    <div class="page-a4 page-tabela page-analise no-background">
      <!-- HEADER -->
      <div class="page-header">
        <img src="/logo.png" class="logo-top" />
        <span class="header-title">
          ESTUDO ESTRATÉGICO / PLANO DE DIVULGAÇÃO
        </span>
      </div>
      <hr class="divider" />
      <!-- TÍTULO -->
      <h2>
        Tabela comparativa do seu imóvel com as principais ofertas similares que
        encontramos no mercado
      </h2>

      <hr class="divider" />

      <!-- TABELA -->
      <table class="comparative-table">
        <thead>
          <tr>
            <th>Endereço</th>
            <th>Área<br />priv.</th>
            <th>Dorm.</th>
            <th>Banh.</th>
            <th>Vagas</th>
            <th>Preço</th>
            <th>Referência</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="(item, index) in imoveis"
            :key="index"
            :class="{ highlight: item.highlight }"
          >
            <td>{{ item.bairro }}</td>
            <td>{{ item.area }}</td>
            <td>{{ item.dormitorios }}</td>
            <td>{{ item.banheiros }}</td>
            <td>{{ item.garagens }}</td>
            <td>{{ item.valor }}</td>
            <!-- <td>{{ item.imobiliaria }}</td> -->
            <td>
              <a
                v-if="item.url"
                :href="item.url"
                target="_blank"
              >
                Ver
              </a>
              <span v-else>{{ item.imobiliaria }}</span>
            </td>
          </tr>
        </tbody>

        <!-- RESULTADO MÉDIO -->
        <tfoot>
          <tr>
            <td>Resultado médio</td>
            <td>{{ media.area }}</td>
            <td colspan="2"></td>
            <td>Média:</td>
            <td>{{ mediana }}</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
      <hr class="divider" />
      <div class="valor-range-wrapper">
        <!-- CARDS -->
        <div class="cards">
          <div
            v-for="(card, index) in cards"
            :key="index"
            class="card"
          >
            <h4>{{ card.titulo }}</h4>
            <div class="valor">{{ card.valor }}</div>
            <small>{{ card.descricao }}</small>
          </div>
        </div>

        <!-- BARRA DE GRADIENTE -->
        <div class="gradient-bar">
          <span
            v-for="n in 60"
            :key="n"
            class="tick"
          />
        </div>
      </div>
      <!-- OBSERVAÇÃO -->
      <p class="note">
        {{ observacao }}
      </p>
    </div>
  </div>
</template>
<script setup>
import { file } from 'jszip';
import { ref } from "vue";
import { onMounted } from "vue";
import { defineProps } from "vue";
import fs from 'fs';
import html2pdf from "html2pdf.js";

const props = defineProps({
  imoveis: {
    type: Array,
    required: true,
  },
  mediana: {
    type: String,
  }
});

// variável que recebe os dados da tabela de imóveis
const imoveis = props.imoveis || dados_para_a_tabela;
const mediana = props.mediana

// defineProps({
//   logo: {
//     type: String,
//     required: true,
//   },

//   rodape: {
//     type: String,
//     default: "www.avantorimoveis.com.br",
//   },

//   caracteristicas: {
//     type: Array,
//     required: true,
//     /*
//       [
//         { label: "Endereço", value: "Rua X" },
//         { label: "Bairro", value: "Centro" },
//         ...
//       ]
//     */
//   },

//   metodologiaTexto: {
//     type: String,
//     required: true,
//   },

//   criteriosComparacao: {
//     type: Array,
//     required: true,
//     /*
//       [
//         "Áreas privativas semelhantes",
//         "Mesma região ou regiões equivalentes",
//         ...
//       ]
//     */
//   },

//   conclusaoTexto: {
//     type: String,
//     required: true,
//   },
// });
// variáveis de teste para a page-dados
const metodologiaTexto =
  "Para realizar o estudo de mercado do seu imóvel, analisamos diversas ofertas similares na região, considerando fatores como localização, tamanho, estado de conservação e características específicas. Utilizamos dados atualizados do mercado imobiliário para garantir uma avaliação precisa e confiável.";
const criteriosComparacao = [
  "Áreas privativas semelhantes",
  "Mesma região ou regiões equivalentes",
  "Estado de conservação similar",
  "Características específicas do imóvel",
];
const conclusaoTexto =
  "Com base na análise realizada, concluímos que o valor ideal para o seu imóvel é competitivo e atrativo para o mercado atual, garantindo uma venda rápida e eficiente.";
const caracteristicas = [
  { label: "Endereço", value: "Rua X, 123" },
  { label: "Bairro", value: "Centro" },
  { label: "Cidade", value: "São Paulo" },
  { label: "Tipo de Imóvel", value: "Apartamento" },
  { label: "Área Privativa", value: "85 m²" },
  { label: "Número de Quartos", value: "3" },
  { label: "Número de Banheiros", value: "2" },
  { label: "Vagas de Garagem", value: "1" },
];

const dados_para_a_tabela = [
  {
    endereco: "Rua A, 100",
    area: "80 m²",
    dorm: 2,
    suites: 1,
    banh: 2,
    vagas: 1,
    portaria: "Sim",
    infra: "Completa",
    preco: "R$ 450.000",
    precoM2: "R$ 5.625",
    referencia: "Zap Imóveis",
    referenciaUrl: "https://www.zapimoveis.com.br/imovel/12345",
    highlight: false,
  },
  {
    endereco: "Rua B, 200",
    area: "90 m²",
    dorm: 3,
    suites: 2,
    banh: 3,
    vagas: 2,
    portaria: "Sim",
    infra: "Completa",
    preco: "R$ 600.000",
    precoM2: "R$ 6.666",
    referencia: "VivaReal",
    referenciaUrl: "https://www.vivareal.com.br/imovel/67890",
    highlight: true,
  },
];
const media = {
    area: "85 m²",
    preco: "R$ 525.000",
    precoM2: "R$ 6.145",
  };

const cards = [
  {
    titulo: "Preço sugerido de venda",
    valor: "R$ 520.000",
    descricao: "Valor ideal para venda rápida e eficiente",
  },
  {
    titulo: "Preço máximo recomendado",
    valor: "R$ 580.000",
    descricao: "Acima deste valor, o imóvel pode demorar mais para vender",
  },
  {
    titulo: "Preço mínimo recomendado",
    valor: "R$ 480.000",
    descricao: "Abaixo deste valor, pode haver perda de patrimônio",
  },
];

const pagina = {
    banner: "/banner.png",
    logo: "/logo.png",
    titulo: `ESTUDO
      ESTRATÉGICO
      DE MERCADO
      COM PLANO
      DE DIVULGAÇÃO
      DO SEU IMÓVEL`,
    corretor: {
      nome: "Fulano Beltrano",
      telefone: "(55) 99999-0484",
      email: "fulano@avantor.com.br",
      foto: "/avatar.png",
    },
  };
async function loadPrintStyles() {
  const res = await fetch('/assets/estilo.css');

  if (!res.ok) {
    throw new Error('Erro ao carregar CSS: ' + res.status);
  }

  const css = await res.text();
  console.log('CSS carregado com sucesso:', css.substring(0, 200));

  return css;
}
function injectPrintStyle(css) {
  let styleTag = document.getElementById('print-style');

  if (!styleTag) {
    styleTag = document.createElement('style');
    styleTag.id = 'print-style';
    document.head.appendChild(styleTag);
  }

  styleTag.innerHTML = css;
}


async function gerarPDF() {
  const element = document.getElementById('print-area');
  if (!element) return;

  const css = await loadPrintStyles();
  injectPrintStyle(css);

  const opt = {
    margin: [0, 0, 0, 0],
    filename: 'relatorio.pdf',
    image: { type: 'jpeg', quality: 1 },
    html2canvas: {
      scale: 2,
      useCORS: true,
      backgroundColor: '#ffffff',
      letterRendering: true
    },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
    pagebreak: { mode: ['css'] }
  };

  await html2pdf().set(opt).from(element).save();
}


/* substituir getPrintStyles por arquivo externo */
/* carregar css do arquivo estilo.css */


function printDiv() {
  // desativar as margens do body para impressão
  document.body.style.margin = "0";
  const content = document.getElementById("print-area").innerHTML;

  const printWindow = window.open("", "", "width=800,height=600");

  printWindow.document.write(`
    <html>
      <head>
        <title>Relatório</title>
        <style>
          ${getPrintStyles()}
        </style>
      </head>
      <body>
        ${content}
      </body>
    </html>
  `);

  printWindow.document.close();
  printWindow.focus();

  setTimeout(() => {
    printWindow.print();
    printWindow.close();
  }, 300);
}


// function getPrintStyles() {
//   return `
    
//   `;
// }
onMounted(() => {
  // carregar o css na página também:
  loadPrintStyles().then(css => injectPrintStyle(css));
});
</script>