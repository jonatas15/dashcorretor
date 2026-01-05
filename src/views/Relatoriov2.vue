<template>
  <!-- BOTÃO -->
  <button class="print-btn" @click="printDiv">Imprimir PDF</button>

  <!-- ÁREA IMPRIMÍVEL -->
  <div
    id="print-area"
    style="/** zoom para a pagina aparecer inteira */ zoom: 0.7"
  >
    <div v-for="(pagina, index) in paginas" :key="index" class="page-a4">
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
            <span>{{ pagina.corretor.telefone }}</span>
            <span>{{ pagina.corretor.email }}</span>
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
      <div class="page-footer">
        <span>www.avantorimoveis.com.br</span>
      </div>
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
            <th>Suítes</th>
            <th>Banh.</th>
            <th>Vagas</th>
            <th>Portaria</th>
            <th>Infra</th>
            <th>Preço</th>
            <th>Preço/m²</th>
            <th>Referência</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="(item, index) in dados_para_a_tabela"
            :key="index"
            :class="{ highlight: item.highlight }"
          >
            <td>{{ item.endereco }}</td>
            <td>{{ item.area }}</td>
            <td>{{ item.dorm }}</td>
            <td>{{ item.suites }}</td>
            <td>{{ item.banh }}</td>
            <td>{{ item.vagas }}</td>
            <td>{{ item.portaria }}</td>
            <td>{{ item.infra }}</td>
            <td>{{ item.preco }}</td>
            <td>{{ item.precoM2 }}</td>
            <td>
              <a
                v-if="item.referenciaUrl"
                :href="item.referenciaUrl"
                target="_blank"
              >
                Ver
              </a>
              <span v-else>{{ item.referencia }}</span>
            </td>
          </tr>
        </tbody>

        <!-- RESULTADO MÉDIO -->
        <tfoot>
          <tr>
            <td>Resultado médio</td>
            <td>{{ media.area }}</td>
            <td colspan="6"></td>
            <td>{{ media.preco }}</td>
            <td>{{ media.precoM2 }}</td>
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

const paginas = [
  {
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
  },
];

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
/* substituir getPrintStyles por arquivo externo */
/* carregar css do arquivo estilo.css */
import printCss from '@/assets/estilo.css?raw';
function getPrintStyles() {
  return printCss;
}

// function getPrintStyles() {
//   return `
    
//   `;
// }
</script>

<style scoped>
/* ===== RESET BÁSICO ===== */
* {
  box-sizing: border-box;
}

/* ===== BOTÃO ===== */
.print-btn {
  margin: 10mm;
  padding: 4mm 8mm;
  font-size: 4mm;
  cursor: pointer;
}

/* ===== PÁGINA A4 ===== */
.page-a4 {
  width: 210mm;
  height: 297mm;
  background: #ffffff;
  font-family: Arial, Helvetica, sans-serif;
  color: #0b2a55;
  overflow: hidden;
  page-break-after: always;
  break-after: page;
  background-image: url("/banner-inteiro.png");
  background-size: contain;
  background-position: center;
}
.no-background {
  background-image: none !important;
}

/* Remove quebra da última página */
.page-a4:last-child {
  page-break-after: auto;
  break-after: auto;
}

/* ===== BANNER ===== */
.header {
  height: 150mm;
  background-size: cover;
  background-position: center;
}

/* ===== CONTEÚDO ===== */
.content {
  display: flex;
  padding: 20mm;
  height: calc(297mm - 140mm);
}

/* ===== COLUNA ESQUERDA ===== */
.left {
  flex: 1;
  margin-top: 20mm;
  text-align: left;
}

.left h1 {
  white-space: pre-line;
  font-size: 9mm;
  line-height: 1.2;
  font-weight: 500;
  letter-spacing: 0.3mm;
}

/* ===== COLUNA DIREITA ===== */
.right {
  width: 60mm;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: left;
  margin-left: 30mm;
}

/* ===== AVATAR ===== */
.avatar {
  width: 55mm;
  height: 55mm;
  border-radius: 50%;
  overflow: hidden;
  border: 4mm solid #0b2a55;
  margin-bottom: 6mm;
  margin-top: -10mm;
}

.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* ===== INFO CORRETOR ===== */
.broker-info {
  text-align: left;
  font-size: 3.2mm;
  line-height: 1.4;
  margin-bottom: 12mm;
}

.broker-info .label {
  font-size: 2.6mm;
  color: #6b7280;
}

.broker-info strong {
  display: block;
  font-size: 3.5mm;
  margin: 1mm 0;
}

/* ===== LOGO ===== */
.logo img {
  width: 35mm;
  margin-top: auto;
}

/* ===== PRINT ===== */
@media print {
  body {
    margin: 0;
  }

  .print-btn {
    display: none;
  }

  .page-a4 {
    box-shadow: none;
  }

  * {
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
}
.page-analise {
  padding: 15mm 20mm;
  font-family: Arial, Helvetica, sans-serif;
  color: #0b2a55;
}

/* HEADER */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-top {
  height: 8mm;
}

.header-title {
  font-size: 3mm;
  color: #6b7280;
}

/* LINHAS */
.divider,
.section-divider {
  border: none;
  border-top: 0.4mm solid #0b2a55;
  margin: 6mm 0;
}

/* TEXTO */
.page-body {
  text-align: left;
}
.page-body h2 {
  font-size: 5mm;
  margin-bottom: 5mm;
}

.page-body h3 {
  font-size: 4mm;
  margin: 6mm 0 3mm;
}

.page-body p {
  font-size: 3.2mm;
  line-height: 1.6;
  margin-bottom: 4mm;
}

/* GRÁFICO DE PREÇO */
.price-chart {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 2mm;
  margin: 8mm 0;
}

.price-chart .label {
  font-size: 2.6mm;
  text-align: center;
  width: 20mm;
}

.pill {
  height: 18mm;
  padding: 0 6mm;
  border-radius: 9mm;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3.2mm;
  font-weight: bold;
  color: #ffffff;
}

.pill.blue {
  background: #1e4fd8;
  width: 50mm;
}

.pill.yellow {
  background: #fbbf24;
  color: #0b2a55;
}

.pill.orange {
  background: #fb923c;
}

.pill.red {
  background: #e11d48;
}

/* LISTA */
.advantages {
  font-size: 3.2mm;
  line-height: 1.6;
  padding-left: 6mm;
}

/* RODAPÉ */
.page-footer {
  position: absolute;
  bottom: 10mm;
  right: 20mm;
  font-size: 2.8mm;
  color: #0b2a55;
}

/** Container */
.containerx {
  text-align: center;
  font-family: sans-serif;
}
.timeline {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 160mm;
  margin-bottom: 3mm;
}
.left-label {
  color: #1a4e8a;
  font-weight: bold;
  font-size: 10pt;
  white-space: nowrap;
}
.right-label {
  color: #d32f2f;
  font-weight: bold;
  font-size: 10pt;
  white-space: nowrap;
}
.arrow {
  flex: 1;
  height: 0.5mm;
  background-color: #1a4e8a;
  position: relative;
  margin: 0 3mm;
}
.arrow::after {
  content: "";
  position: absolute;
  right: -1.5mm;
  top: -1mm;
  border: 1.3mm solid transparent;
  border-left-color: #1a4e8a;
}
.bar {
  display: flex;
  width: 160mm;
  border-radius: 13mm;
  overflow: hidden;
  box-shadow: 0 0.5mm 1mm rgba(0, 0, 0, 0.1);
}
.segment {
  color: white;
  font-weight: bold;
  font-size: 12pt;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3mm 5mm;
  white-space: nowrap;
  height: 20mm;
  /* border-radius: 50% 0 0 50%; */
  /** sobrepor os segmentos um sobre o outro: */
}
.blue {
  background-color: #1a73e8;
  flex: 2; /* Larger width for the first segment */
}
.yellow {
  background-color: #fbbc04;
  flex: 1;
}
.orange {
  background-color: #ea8600;
  flex: 1;
}
.red {
  background-color: #d93025;
  flex: 1;
}

/**  TERCEIRA PÁGINA */
.page-marketing {
  padding: 15mm 20mm;
  font-family: Arial, Helvetica, sans-serif;
  color: #0b2a55;
}

/* HEADER */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-top {
  height: 8mm;
}

.header-title {
  font-size: 3mm;
  color: #6b7280;
}

/* DIVISORES */
.divider,
.section-divider {
  border: none;
  border-top: 0.4mm solid #0b2a55;
  margin: 6mm 0;
}

.row-divider {
  border: none;
  border-top: 0.2mm solid #e5e7eb;
  margin: 6mm 0;
}

/* TÍTULO */
.page-marketing h2 {
  font-size: 5mm;
  margin-bottom: 4mm;
}

/* INTRO */
.intro {
  font-size: 3.2mm;
  line-height: 1.6;
  margin-bottom: 6mm;
  max-width: 160mm;
}

/* LINHAS */
.marketing-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  text-align: left;
}

.marketing-row ul {
  font-size: 3.2mm;
  line-height: 1.6;
  padding-left: 5mm;
  margin: 0;
  width: 110mm;
}

.marketing-row li {
  margin-bottom: 1.5mm;
}

/* ÍCONES */
.icons {
  display: flex;
  gap: 6mm;
  align-items: center;
}

.icons img {
  height: 10mm;
  object-fit: contain;
}

/* RODAPÉ */
.page-footer {
  position: absolute;
  bottom: 10mm;
  right: 20mm;
  font-size: 2.8mm;
  color: #0b2a55;
}
/** Quarta página */
.page-dados {
  padding: 15mm 20mm;
  font-family: Arial, Helvetica, sans-serif;
  color: #0b2a55;
  text-align: left !important;
}

/* HEADER */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-top {
  height: 8mm;
}

.header-title {
  font-size: 3mm;
  color: #6b7280;
}

/* DIVISORES */
.divider,
.section-divider {
  border: none;
  border-top: 0.4mm solid #0b2a55;
  margin: 6mm 0;
}

/* TÍTULOS */
.page-dados h2 {
  font-size: 4.5mm;
  margin-bottom: 3mm;
}

.page-dados h3 {
  font-size: 3.6mm;
  margin: 4mm 0 2mm;
  color: #1e3a8a;
}

/* LISTAS */
.data-list {
  font-size: 3.2mm;
  line-height: 1.6;
  padding-left: 5mm;
  margin-bottom: 6mm;
}

.data-list li {
  margin-bottom: 1.2mm;
}

/* TEXTO */
.text {
  font-size: 3.2mm;
  line-height: 1.6;
  margin-bottom: 4mm;
}

/* RODAPÉ */
.page-footer {
  position: absolute;
  bottom: 10mm;
  right: 20mm;
  font-size: 2.8mm;
  color: #0b2a55;
}
/** Quinta página */
.page-tabela {
  padding: 15mm 20mm;
  font-family: Arial, Helvetica, sans-serif;
  color: #0b2a55;
}

/* TÍTULO */
.page-tabela h2 {
  font-size: 4.5mm;
  margin-bottom: 4mm;
}

/* DIVISOR */
.divider {
  border: none;
  border-top: 0.4mm solid #0b2a55;
  margin-bottom: 6mm;
}

/* TABELA */
.comparative-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 2.8mm;
}

/* CABEÇALHO */
.comparative-table thead th {
  background: #0b4aa2;
  color: #ffffff;
  padding: 3mm 2mm;
  text-align: center;
  border-right: 0.2mm solid #ffffff;
}

.comparative-table thead th:last-child {
  border-right: none;
}

/* CORPO */
.comparative-table tbody td {
  padding: 3mm 2mm;
  border-bottom: 0.2mm solid #e5e7eb;
  text-align: center;
}

.comparative-table tbody td:first-child {
  text-align: left;
}

/* LINHA DESTACADA */
.comparative-table tbody tr.highlight {
  background: #e6f2ff;
}

/* RODAPÉ */
.comparative-table tfoot td {
  background: #0b4aa2;
  color: #ffffff;
  padding: 3mm 2mm;
  font-weight: bold;
}

/* LINKS */
.comparative-table a {
  color: #1d4ed8;
  text-decoration: none;
}

/* OBSERVAÇÃO */
.note {
  font-size: 2.6mm;
  line-height: 1.6;
  color: #4b5563;
  margin-top: 6mm;
}
/** CARD FINAL */
.valor-range-wrapper {
  margin-top: 12mm;
  font-family: Arial, Helvetica, sans-serif;
}

/* CARDS */
.cards {
  display: flex;
  justify-content: space-between;
  gap: 6mm;
  margin-bottom: 8mm;
}

.card {
  flex: 1;
  background: #ffffff;
  border-radius: 2mm;
  padding: 6mm 4mm;
  text-align: center;
  box-shadow: 0 0.6mm 2mm rgba(0, 0, 0, 0.08);
}

.card h4 {
  font-size: 3mm;
  font-weight: bold;
  color: #1e2a5a;
  margin-bottom: 4mm;
}

.card .valor {
  font-size: 4mm;
  font-weight: bold;
  color: #1e2a5a;
  margin-bottom: 3mm;
}

.card small {
  font-size: 2.6mm;
  color: #6b7280;
}

/* BARRA DE GRADIENTE */
.gradient-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 5mm;
}

.tick {
  flex: 1;
  height: 100%;
  margin: 0 0.4mm;
  border-radius: 0.6mm;
  background: linear-gradient(
    to right,
    #ff0000,
    #ff7a00,
    #ffd500,
    #7ed957,
    #2ecc71
  );
}
@media print {
  .container {
    /* Ajustes opcionais para impressão/PDF */
    page-break-inside: avoid;
  }
}
</style>
