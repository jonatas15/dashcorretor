<template>
  <!-- BOTÃO -->
  <button class="print-btn" @click="printDiv">Imprimir PDF</button>

  <!-- ÁREA IMPRIMÍVEL -->
  <div id="print-area" style="/** zoom para a pagina aparecer inteira */ zoom: .4;">
    <div v-for="(pagina, index) in paginas" :key="index" class="page-a4">
      <div
        class="header"
        :style="{ backgroundImage: `url(${pagina.banner})` }"
      ></div>

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
    <div class="page-a4 page-analise">
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
      Entender a posição do seu imóvel no mercado é o primeiro passo
      para realizar uma venda com qualidade e segurança. Para isso,
      realizamos um estudo com base nas características do seu imóvel
      e nas ofertas de imóveis similares na região.
    </p>

    <p>
      O objetivo principal deste estudo é identificar o valor correto
      de venda. Esse valor é o que posiciona o seu imóvel com destaque
      no mercado e evita que ele acabe ajudando a vender os imóveis
      concorrentes.
    </p>

    <hr class="section-divider" />

    <h3>RELAÇÃO ENTRE PREÇO E VELOCIDADE DE VENDA</h3>

    <p>
      A velocidade de venda de seu imóvel está diretamente relacionada
      à precificação correta. Nosso histórico de vendas mostra que
      imóveis anunciados acima do preço de mercado tendem a ter um
      processo de venda mais lento.
    </p>

    <p>
      Além disso, muitas vezes o valor final negociado acaba sendo
      inferior ao valor real de mercado, o que resulta em perda de
      patrimônio.
    </p>

    <!-- GRÁFICO SIMPLIFICADO -->
    <div class="price-chart">
      <span class="label left">MENOS TEMPO<br />DE VENDA</span>

      <div class="pill blue">PREÇO DE<br />MERCADO</div>
      <div class="pill yellow">+10%</div>
      <div class="pill orange">+20%</div>
      <div class="pill red">+30%</div>

      <span class="label right">MAIS TEMPO<br />DE VENDA</span>
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
  <div class="page-footer">
    <span>www.avantorimoveis.com.br</span>
  </div>
</div>

  </div>
</template>
<script setup>
const paginas = [
  {
    banner: "/banner.jpg",
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
      foto: "/corretor.png",
    },
  },
];

function printDiv() {
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

function getPrintStyles() {
  return `
    * {
      box-sizing: border-box;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    body {
      margin: 0;
    }

    .page-a4 {
      width: 210mm;
      height: 297mm;
      page-break-after: always;
      break-after: page;
      font-family: Arial, Helvetica, sans-serif;
      color: #0b2a55;
    }

    .page-a4:last-child {
      page-break-after: auto;
      break-after: auto;
    }

    .header {
      height: 140mm;
      background-size: cover;
      background-position: center;
    }

    .content {
      display: flex;
      padding: 20mm;
      height: calc(297mm - 140mm);
    }

    .left {
      flex: 1;
    }

    .left h1 {
      white-space: pre-line;
      font-size: 10mm;
      line-height: 1.2;
      letter-spacing: 0.3mm;
    }

    .right {
      width: 60mm;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .avatar {
      width: 35mm;
      height: 35mm;
      border-radius: 50%;
      overflow: hidden;
      border: 1mm solid #0b2a55;
      margin-bottom: 6mm;
    }

    .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .broker-info {
      text-align: center;
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

    .logo img {
      width: 35mm;
      margin-top: auto;
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

  `;
}
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
}

/* Remove quebra da última página */
.page-a4:last-child {
  page-break-after: auto;
  break-after: auto;
}

/* ===== BANNER ===== */
.header {
  height: 140mm;
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
}

.left h1 {
  white-space: pre-line;
  font-size: 10mm;
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
}

/* ===== AVATAR ===== */
.avatar {
  width: 35mm;
  height: 35mm;
  border-radius: 50%;
  overflow: hidden;
  border: 1mm solid #0b2a55;
  margin-bottom: 6mm;
}

.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* ===== INFO CORRETOR ===== */
.broker-info {
  text-align: center;
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

</style>
