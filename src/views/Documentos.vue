<template>
  <div class="container text-left">
    <div class="row align-items-start">
      <div class="col-md-12 banner" style="position: relative">
        <!-- <img src="src/assets/banner/banner-1.png" /> -->
        <div class="vertical-center" style="width: 305px !important">
          <h5 class="titulo-dash" style="">
            Veja como estipular suas<br />
            metas de maneiras alcançáveis.
          </h5>
          <a class="btn btn-transparente float-right" href="#">ver mais</a>
        </div>
      </div>
      <div class="col-md-12 dash-corretor my-5 py-5" style="min-height: 400px;">
        <div class="mt-5">

             <button @click="downloadPDF" class="btn btn-danger me-2 py-3">
                <font-awesome-icon icon="file-pdf" class="fa-2xl mt-1" />
                <br>
                <br>
                <strong>Acompanhamento <br>de Leads</strong>
            </button>
            <button @click="downloadExcel" class="btn btn-success me-2 py-3">
                <font-awesome-icon icon="file-excel" class="fa-2xl mt-1" />
                <br>
                <br>
                <strong>Análise de Imóveis <br>Visitados</strong>
            </button>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
export default {
  methods: {
    downloadPDF() {
      const link = document.createElement("a");
      link.href = "./assets/documentos/leadsacompanhamento.pdf";
      link.download = "leadsacompanhamento.pdf";
      link.click();
    },
    downloadExcel() {
        const link = document.createElement("a");
        link.href = "./assets/documentos/analiseimoveisvisitados.xlsx";
      link.download = "analiseimoveisvisitados.xlsx";
      link.click();
    },
  },
};
</script>
  
  <style scoped>
.container {
  text-align: center;
}
</style>
  