<template>
    <div class="bg-white p-5 w-full" style="
        border-top-right-radius: 90px;
        border-bottom-right-radius: 90px;
    ">
        <h3>Download de Imagens por código do imóvel</h3>
        <hr>
        <font-awesome-icon icon="gauge" class="fa-2xl p-5 fs-100" />
        <br>
      <input v-model="codigoImovel" placeholder="Digite o código do imóvel" />
      <button @click="downloadZip" :disabled="isDownloading">
        {{ isDownloading ? "Baixando..." : "Baixar Imagens" }}
      </button>
      <div v-if="isDownloading" class="progress-bar">
        <div class="progress" :style="{ width: progress + '%' }"></div>
      </div>
      <div v-if="isDownloading">
        <img src="@/assets/actions/please-wait.gif" />
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        codigoImovel: "", // Código informado pelo usuário
        isDownloading: false,
        progress: 0
      };
    },
    methods: {
      async downloadZip() {
        if (!this.codigoImovel) {
          alert("Por favor, informe o código do imóvel.");
          return;
        }
        
        this.isDownloading = true;
        this.progress = 10; // Inicia a barra de progresso
        
        try {
          const response = await axios.get(`https://www.cafeimobiliaria.com.br/gerar_zip.php?codigo=${this.codigoImovel}`, {
            responseType: "blob",
            onDownloadProgress: (progressEvent) => {
              if (progressEvent.total) {
                this.progress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
              }
            }
          });
          
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", `imovel_${this.codigoImovel}.zip`);
          document.body.appendChild(link);
          link.click();
          
          // Pergunta onde salvar o arquivo
          setTimeout(() => {
            window.URL.revokeObjectURL(url);
            document.body.removeChild(link);
          }, 100);
          
        } catch (error) {
          console.error("Erro ao baixar ZIP:", error);
          alert("Não foi possível gerar o arquivo ZIP.");
        } finally {
          this.isDownloading = false;
          this.progress = 0;
        }
      }
    }
  };
  </script>
  
  <style scoped>
  input {
    padding: 8px;
    margin-right: 10px;
    font-size: 16px;
  }
  button {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
  }
  .progress-bar {
    width: 100%;
    height: 10px;
    background: #ddd;
    margin-top: 10px;
    border-radius: 5px;
    overflow: hidden;
  }
  .progress {
    height: 100%;
    background: #4caf50;
    width: 0%;
    transition: width 0.3s ease;
  }
  .fs-100 {
    font-size: 50px !important;
  }
  </style>
  