<template>
  <div class="pdf-container">
    <!-- Page 1 -->
    <div class="page page-1">
      <div class="header-background">
        <img :src="balloonImage" alt="Avantor Balloon" class="balloon-img" crossOrigin="anonymous">
      </div>
      <div class="title-bar">
        <img :src="avantorLogo2" alt="Avantor Logo" class="title-logo" crossOrigin="anonymous">
        <h1>ESTUDO DE MERCADO E PLANO DE MARKETING PARA VENDA DO SEU IMÓVEL</h1>
      </div>
      <div class="content">
        <div class="left-column">
          <p><strong>Proprietário:</strong></p>
          <p>{{ studyData.proprietario }}</p>
          <p><strong>Endereço:</strong></p>
          <p>{{ studyData.endereco }}</p>
          <p><strong>Código do estudo:</strong> {{ studyData.codigo }}</p>
          <p><strong>Atualizado em</strong> {{ studyData.atualizado }}</p>
        </div>
        <div class="agent-card">
          <p>Este estudo foi feito por</p>
          <h2>{{ studyData.agent.name }}</h2>
          <p>Creci: {{ studyData.agent.creci }} | {{ studyData.agent.phone }}</p>
          <p>{{ studyData.agent.email }}</p>
          <img :src="avantorLogo" alt="Avantor Logo" class="agent-logo" crossOrigin="anonymous">
          <img :src="studyData.agent.photo" alt="Agent Photo" class="agent-photo" crossOrigin="anonymous">
        </div>
      </div>
    </div>

    <!-- Page 2 -->
    <div class="page">
      <div class="page-header">
        <img :src="avantorLogo" alt="Avantor Logo" class="small-logo" crossOrigin="anonymous">
        <p class="small-title">Estudo de mercado e plano de marketing</p>
      </div>
      <div class="content">
        <h2>Olá, {{ studyData.proprietario }}.</h2>
        <p>Entender qual a posição do seu imóvel no mercado é o primeiro passo para realizar a venda com qualidade e segurança. Para isso, realizei um estudo feito com base nas características do seu imóvel e das ofertas de imóveis similares na região.</p>
        <p>O objetivo principal deste estudo é identificar qual o valor correto de venda. É este valor que irá posicionar o seu imóvel com destaque no mercado e não fará com que ele ajude a vender os imóveis concorrentes.</p>
        <h3>Relação do preço com a velocidade de venda.</h3>
        <p>A velocidade de venda do seu imóvel está diretamente relacionada a precificação correta. Nosso histórico de vendas mostra que, imóveis com avaliações acima do preço de mercado, tem como resultado um processo de venda mais lento. Além de demorar mais, muitas vezes o valor final de venda é ainda inferior ao valor real de mercado, o que ocasiona perda de patrimônio.</p>
        <div class="price-speed-graph">
          <div class="less-time">Menor tempo</div>
          <div class="bar">
            <div class="segment blue">Preço de mercado</div>
            <div class="segment yellow">+10%</div>
            <div class="segment orange">+20%</div>
            <div class="segment red">+30%</div>
          </div>
          <div class="more-time">Maior tempo para venda</div>
          <p>Quanto mais ajustado o preço, menor o tempo de venda.</p>
        </div>
        <h3>Vantagens de se ter o imóvel com o preço correto.</h3>
        <ul class="advantages">
          <li>Venda dentro de um prazo mais curto.</li>
          <li>Menos inconvenientes.</li>
          <li>Mais clientes interessados, logo, um maior número de visitas.</li>
          <li>Corretores motivados em mostrar o imóvel aos seus clientes.</li>
          <li>Propostas mais assertivas.</li>
          <li>Menos chances de perder dinheiro.</li>
          <li>Seu imóvel representado por apenas um corretor.</li>
        </ul>
      </div>
      <div class="footer">
        <p>Endereço: {{ studyData.footer.address }} - CRECI-RS Telefone: {{ studyData.footer.phone }}</p>
        <img :src="avantorLogo" alt="Avantor Logo" class="footer-logo" crossOrigin="anonymous">
      </div>
    </div>

    <!-- Page 3 -->
    <div class="page">
      <div class="page-header">
        <img :src="avantorLogo" alt="Avantor Logo" class="small-logo" crossOrigin="anonymous">
        <p class="small-title">Estudo de mercado e plano de marketing</p>
      </div>
      <div class="content">
        <h2>Plano de marketing personalizado</h2>
        <p>Desenvolvemos para cada imóvel um plano de marketing especial, que vai muito além da simples publicação de ofertas em um site. Vamos entender, preparar e divulgar seu imóvel nos canais certos para as pessoas certas.</p>
        <ul class="marketing-list">
          <li>
            <img :src="avantorAgencyLogo" alt="Avantor Agency" crossOrigin="anonymous">
            <p>Divulgação no portal Avantor da minha agência</p>
          </li>
          <li>
            <img :src="avantorRegionalLogo" alt="Avantor Regional" crossOrigin="anonymous">
            <p>Divulgação no portal Avantor da minha regional</p>
          </li>
          <li>
            <img :src="avantorBrazilLogo" alt="Avantor Brazil" crossOrigin="anonymous">
            <p>Divulgação no portal Avantor BR a nível nacional</p>
          </li>
          <li>
            <img :src="photographerIcon" alt="Photographer" crossOrigin="anonymous">
            <p>Fotos profissionais</p>
          </li>
          <li>
            <img :src="videoIcon" alt="Video" crossOrigin="anonymous">
            <p>Vídeo do imóvel</p>
          </li>
          <li>
            <img :src="vivarealLogo" alt="VivaReal" crossOrigin="anonymous">
            <p>Divulgação no portal Vivareal</p>
          </li>
          <li>
            <img :src="zapLogo" alt="Zap" crossOrigin="anonymous">
            <p>Divulgação no portal Zap</p>
          </li>
          <li>
            <img :src="olxLogo" alt="OLX" crossOrigin="anonymous">
            <p>Divulgação no portal Olx</p>
          </li>
          <li>
            <img :src="emailIcon" alt="Email" crossOrigin="anonymous">
            <p>Envio de email marketing para clientes compradores</p>
          </li>
          <li>
            <img :src="emailIcon" alt="Email" crossOrigin="anonymous">
            <p>Envio de email marketing para corretores parceiros</p>
          </li>
          <li>
            <img :src="emailIcon" alt="Email" crossOrigin="anonymous">
            <p>Envio de email marketing para imobiliárias parceiras</p>
          </li>
          <li>
            <img :src="facebookLogo" alt="Facebook" crossOrigin="anonymous">
            <p>Divulgação no Facebook</p>
          </li>
          <li>
            <img :src="instagramLogo" alt="Instagram" crossOrigin="anonymous">
            <p>Divulgação no Instagram</p>
          </li>
          <li>
            <img :src="googleLogo" alt="Google" crossOrigin="anonymous">
            <p>Divulgação no Google</p>
          </li>
          <li>
            <img :src="partnersIcon" alt="Partners" crossOrigin="anonymous">
            <p>Visita com corretores parceiros no imóvel</p>
          </li>
          <li>
            <img :src="feedbackIcon" alt="Feedback" crossOrigin="anonymous">
            <p>Feedback sobre o andamento das ações e resultados</p>
          </li>
        </ul>
      </div>
      <div class="footer">
        <p>Endereço: {{ studyData.footer.address }} - CRECI-RS Telefone: {{ studyData.footer.phone }}</p>
        <img :src="avantorLogo" alt="Avantor Logo" class="footer-logo" crossOrigin="anonymous">
      </div>
    </div>

    <!-- Page 4 -->
    <div class="page">
      <div class="page-header">
        <img :src="avantorLogo" alt="Avantor Logo" class="small-logo" crossOrigin="anonymous">
        <p class="small-title">Estudo de mercado e plano de marketing</p>
      </div>
      <div class="content">
        <h2>Dados principais do seu imóvel</h2>
        <div class="property-details">
          <div class="characteristics">
            <h3>Características do imóvel</h3>
            <ul>
              <li>Endereço: {{ studyData.property.endereco }}</li>
              <li>Bairro: {{ studyData.property.bairro }}</li>
              <li>Ano de construção: {{ studyData.property.anoConstrucao }}</li>
              <li>Área útil: {{ studyData.property.areaUtil }}</li>
              <li>Dormitórios: {{ studyData.property.dormitorios }}</li>
              <li>Suítes: {{ studyData.property.suites }}</li>
              <li>Banheiros: {{ studyData.property.banheiros }}</li>
              <li>Vagas: {{ studyData.property.vagas }}</li>
            </ul>
          </div>
          <div class="other-characteristics">
            <h3>Outras características</h3>
            <ul>
              <li>Infraestrutura: {{ studyData.property.infraestrutura }}</li>
              <li>Portaria: {{ studyData.property.portaria }}</li>
              <li>Posição solar: {{ studyData.property.posicaoSolar }}</li>
              <li>Estado: {{ studyData.property.estado }}</li>
              <li>Semi-mobiliado: {{ studyData.property.semiMobiliado }}</li>
              <li>Vista panorâmica: {{ studyData.property.vistaPanoramica }}</li>
              <li>Demanda da região: {{ studyData.property.demandaRegiao }}</li>
            </ul>
          </div>
        </div>
        <h3>O que identifiquei no seu imóvel:</h3>
        <!-- Add any specific identification if available -->
        <h3>Metodologia aplicada</h3>
        <p>O estudo é feito a partir de uma amostra de 6 imóveis com características similares ao seu que nos permite entender o posicionamento do seu imóvel no mercado. São imóveis com áreas privativas, região, tipologias, itens de infraestrutura, idade de construção e condições parecidas com a do imóvel analisado.</p>
        <p>As informações obtidas são cruzadas, sofrem ações de variáveis que influenciam diretamente no preço final do imóvel, para então chegarmos em uma sugestão de precificação mais assertiva.</p>
      </div>
      <div class="footer">
        <p>Endereço: {{ studyData.footer.address }} - CRECI-RS Telefone: {{ studyData.footer.phone }}</p>
        <img :src="avantorLogo" alt="Avantor Logo" class="footer-logo" crossOrigin="anonymous">
      </div>
    </div>

    <!-- Page 5 -->
    <div class="page">
      <div class="page-header">
        <img :src="avantorLogo" alt="Avantor Logo" class="small-logo" crossOrigin="anonymous">
        <p class="small-title">Estudo de mercado e plano de marketing</p>
      </div>
      <div class="content">
        <h2>Amostras encontradas no mercado</h2>
        <div class="samples-grid">
          <div v-for="(sample, index) in studyData.samples" :key="index" class="sample-card">
            <div class="placeholder-image"></div>
            <p>{{ sample.location }}</p>
            <p>Área priv.: {{ sample.area }} | Dormitórios: {{ sample.dormitorios }}</p>
            <p class="price">R$ {{ sample.preco }}</p>
          </div>
        </div>
      </div>
      <div class="footer">
        <p>Endereço: {{ studyData.footer.address }} - CRECI-RS Telefone: {{ studyData.footer.phone }}</p>
        <img :src="avantorLogo" alt="Avantor Logo" class="footer-logo" crossOrigin="anonymous">
      </div>
    </div>

    <!-- Page 6 -->
    <div class="page">
      <div class="page-header">
        <img :src="avantorLogo" alt="Avantor Logo" class="small-logo" crossOrigin="anonymous">
        <p class="small-title">Estudo de mercado e plano de marketing</p>
      </div>
      <div class="content">
        <h2>Tabela comparativa do seu imóvel com as principais ofertas similares que encontramos no mercado</h2>
        <table class="comparative-table">
          <thead>
            <tr>
              <th>Endereço</th>
              <th>Área priv.</th>
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
            <tr>
              <td>{{ studyData.property.endereco }}</td>
              <td>{{ studyData.property.areaUtil }}</td>
              <td>{{ studyData.property.dormitorios }}</td>
              <td>{{ studyData.property.suites }}</td>
              <td>{{ studyData.property.banheiros }}</td>
              <td>{{ studyData.property.vagas }}</td>
              <td>{{ studyData.property.portaria }}</td>
              <td>{{ studyData.property.infraestrutura }}</td>
              <td>?</td>
              <td>?</td>
              <td>?</td>
            </tr>
            <tr v-for="(sample, index) in studyData.samples" :key="index">
              <td>{{ sample.endereco }}</td>
              <td>{{ sample.area }}</td>
              <td>{{ sample.dormitorios }}</td>
              <td>0</td>
              <td>1</td>
              <td>1</td>
              <td>Não</td>
              <td>Não tem</td>
              <td>{{ sample.preco }}</td>
              <td>{{ sample.precoM2 }}</td>
              <td>Ver</td>
            </tr>
            <tr class="average">
              <td>Resultado médio</td>
              <td>{{ studyData.average.area }} m²</td>
              <td colspan="6"></td>
              <td>R$ {{ studyData.average.preco }}</td>
              <td>R$ {{ studyData.average.precoM2 }}</td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <p>Usamos como base para este estudo imóveis que estão anunciados nos principais portais de divulgação. A escolha dos imóveis foi feita a partir do nosso conhecimento de mercado e também por apresentarem características que muitas vezes não são encontradas por uma busca automática. Os valores anunciados não são de nossa responsabilidade mas servem como base para um estudo de amostragem.</p>
      </div>
      <div class="footer">
        <p>Endereço: {{ studyData.footer.address }} - CRECI-RS Telefone: {{ studyData.footer.phone }}</p>
        <img :src="avantorLogo" alt="Avantor Logo" class="footer-logo" crossOrigin="anonymous">
      </div>
    </div>

    <!-- Page 7 -->
    <div class="page">
      <div class="page-header">
        <img :src="avantorLogo" alt="Avantor Logo" class="small-logo" crossOrigin="anonymous">
        <p class="small-title">Estudo de mercado e plano de marketing</p>
      </div>
      <div class="content">
        <h2>Localização das amostras utilizadas</h2>
        <div class="map-placeholder">
          <!-- You can replace with a static map image or embed Leaflet map -->
          <img src="https://placeholder.com/800x400?text=Map" alt="Map" crossOrigin="anonymous">
        </div>
        <h3>Resultado encontrado</h3>
        <div class="results">
          <div class="result-box improbable">
            <p>Valor IMPROVÁVEL</p>
            <h4>{{ studyData.results.improvavel }}</h4>
            <p>Igual a média geral</p>
          </div>
          <div class="result-box market">
            <p>Valor DE MERCADO</p>
            <h4>{{ studyData.results.mercado }}</h4>
            <p>Destaque relativo</p>
          </div>
          <div class="result-box competitive">
            <p>Valor COMPETITIVO</p>
            <h4>{{ studyData.results.competitivo }}</h4>
            <p>Grande destaque</p>
          </div>
        </div>
        <div class="gradient-bar"></div>
      </div>
      <div class="footer">
        <p>Endereço: {{ studyData.footer.address }} - CRECI-RS Telefone: {{ studyData.footer.phone }}</p>
        <img :src="avantorLogo" alt="Avantor Logo" class="footer-logo" crossOrigin="anonymous">
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineExpose } from 'vue';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

const props = defineProps({
  studyData: {
    type: Object,
    required: true
  }
});

// Image URLs from search
const avantorLogo = '/corretor/src/assets/logo/1.png';
const avantorLogo2 = '/corretor/src/assets/logo/logo-bgdark.png';
const balloonImage = '/corretor/src/assets/photos/predial.jpeg';
const vivarealLogo = '/corretor/src/assets/logo/icon-bg-clear.png';
const zapLogo ='/corretor/src/assets/logo/icon-bg-clear.png';
const olxLogo ='/corretor/src/assets/logo/icon-bg-clear.png';
const facebookLogo ='/corretor/src/assets/logo/icon-bg-clear.png';
const instagramLogo ='/corretor/src/assets/logo/icon-bg-clear.png';
const googleLogo ='/corretor/src/assets/logo/icon-bg-clear.png';
const photographerIcon ='/corretor/src/assets/logo/icon-bg-clear.png';
const videoIcon ='/corretor/src/assets/logo/icon-bg-clear.png';
const emailIcon ='/corretor/src/assets/logo/icon-bg-clear.png';
const partnersIcon ='/corretor/src/assets/logo/icon-bg-clear.png';
const feedbackIcon ='/corretor/src/assets/logo/icon-bg-clear.png';
const avantorBrazilLogo ='/corretor/src/assets/logo/icon-bg-clear.png';
const avantorRegionalLogo ='/corretor/src/assets/logo/icon-bg-clear.png';
const avantorAgencyLogo ='/corretor/src/assets/logo/icon-bg-clear.png';

// Method to export to PDF
const exportToPDF = async () => {
  const pdf = new jsPDF('p', 'mm', 'a4');
  const pages = document.querySelectorAll('.page');

  const canvasPromises = Array.from(pages).map(page => html2canvas(page, {
    scale: 2, // Reduced scale for better performance (lower quality, faster)
    useCORS: true,
    allowTaint: true,
    logging: false
  }));

  const canvases = await Promise.all(canvasPromises);

  canvases.forEach((canvas, i) => {
    const imgData = canvas.toDataURL('image/png');
    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = pdf.internal.pageSize.getHeight();
    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
    if (i < canvases.length - 1) {
      pdf.addPage();
    }
  });

  pdf.save('estudo_mercado.pdf');
};

defineExpose({ exportToPDF });
</script>

<style scoped>
/* Existing styles remain the same */
.pdf-container {
  font-family: Arial, sans-serif;
  color: #333;
  background: white;
}

.page {
  width: 210mm;
  height: 297mm;
  padding: 20mm;
  box-sizing: border-box;
  position: relative;
  page-break-after: always;
}

/* ... rest of the styles ... */

@media print {
  .page {
    page-break-after: always;
    margin: 0;
    padding: 0;
  }
  @page {
    size: A4 portrait;
    margin: 0;
  }
  .pdf-container {
    margin: 0;
  }
}
</style>
<style scoped>
.pdf-container {
  font-family: Arial, sans-serif;
  color: #333;
  background: white;
}

.page {
  width: 210mm;
  height: 297mm;
  padding: 20mm;
  box-sizing: border-box;
  position: relative;
  page-break-after: always;
}

.page-1 .header-background {
  background-color: #f0f8ff;
  height: 100mm;
  position: relative;
  overflow: hidden;
}

.balloon-img {
  position: absolute;
  right: 0;
  top: 0;
  height: 150%;
  /* transform: rotate(-20deg); */
}

.title-bar {
  background-color: #002d72;
  color: white;
  padding: 10mm;
  display: flex;
  align-items: center;
}

.title-logo {
  width: 40mm;
  margin-right: 10mm;
}

.title-bar h1 {
  font-size: 8mm;
  margin: 0;
}

.left-column {
  float: left;
  width: 50%;
}

.agent-card {
  float: right;
  background: white;
  padding: 5mm;
  border-radius: 3mm;
  box-shadow: 0 0 2mm rgba(0,0,0,0.1);
  text-align: center;
  position: relative;
}

.agent-photo {
  width: 20mm;
  height: 20mm;
  border-radius: 50%;
  position: absolute;
  top: -10mm;
  right: 10mm;
  margin-bottom: 10mm;
}

.agent-logo {
  width: 30mm;
}

.page-header {
  display: flex;
  align-items: center;
  border-bottom: 0.5mm solid #ddd;
  padding-bottom: 2mm;
  margin-bottom: 5mm;
}

.small-logo {
  width: 20mm;
}

.small-title {
  font-size: 4mm;
  color: #002d72;
  margin-left: 70mm;
}

h2, h3 {
  color: #002d72;
}

.advantages li {
  list-style: none;
  padding-left: 5mm;
  position: relative;
}

.advantages li:before {
  content: '✔';
  color: green;
  position: absolute;
  left: 0;
}

.price-speed-graph {
  text-align: center;
}

.bar {
  display: flex;
  justify-content: center;
}

.segment {
  padding: 2mm 5mm;
  color: white;
}

.blue {
  background: #007bff;
}

.yellow {
  background: #ffc107;
}

.orange {
  background: #fd7e14;
}

.red {
  background: #dc3545;
}

.marketing-list li {
  display: flex;
  align-items: center;
  margin-bottom: 3mm;
}

.marketing-list img {
  width: 5mm;
  margin-left: 5mm;
  margin-right: 5mm;
  margin-top: -5mm;
}

.property-details {
  display: flex;
}

.characteristics, .other-characteristics {
  width: 50%;
}

.samples-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 5mm;
}

.sample-card {
  background: #f8f9fa;
  padding: 3mm;
  text-align: center;
}

.placeholder-image {
  background: #ddd;
  height: 30mm;
  margin-bottom: 2mm;
}

.price {
  color: #002d72;
  font-weight: bold;
}

.comparative-table {
  width: 100%;
  border-collapse: collapse;
}

.comparative-table th, .comparative-table td {
  border: 0.2mm solid #ddd;
  padding: 2mm;
}

.comparative-table th {
  background: #002d72;
  color: white;
}

.average {
  background: #002d72;
  color: white;
}

.map-placeholder {
  height: 100mm;
  background: #eee;
  margin-bottom: 5mm;
}

.results {
  display: flex;
  justify-content: space-between;
}

.result-box {
  width: 30%;
  text-align: center;
  padding: 3mm;
  border-radius: 2mm;
  box-shadow: 0 0 2mm rgba(0,0,0,0.1);
}

.improbable {
  background: #dc3545;
  color: white;
}

.market {
  background: #ffc107;
  color: #333;
}

.competitive {
  background: #28a745;
  color: white;
}

.gradient-bar {
  height: 2mm;
  background: linear-gradient(to right, red, orange, yellow, green);
  margin-top: 5mm;
}

.footer {
  position: absolute;
  bottom: 10mm;
  left: 20mm;
  right: 20mm;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 3mm;
  color: #666;
}

.footer-logo {
  width: 20mm;
}

@media print {
  .page {
    page-break-after: always;
    margin: 0;
    padding: 0;
  }
  @page {
    size: A4 portrait;
    margin: 0;
  }
  .pdf-container {
    margin: 0;
  }
}
</style>
