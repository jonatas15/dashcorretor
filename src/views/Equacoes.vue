<script setup>
import { ref, computed, onMounted } from "vue";
import { Money } from "v-money";

// Definição das metas e valores iniciais
const metaVendasAnual = ref("");
const ticketMedio = ref("");
const taxaConversao = ref(5);

// Função para limpar caracteres não numéricos
const parseNumber = (value) => {
  if (typeof value === "number") return value;
  if (!value) return 0;
  return (
    Number(
      String(value)
        .replace(/[^0-9,-]/g, "")
        .replace(".", "")
    ) || 0
  );
};

const metaVendasMensal = computed(
  () => parseNumber(metaVendasAnual.value) / 12
);
const metaOportunidadesMes = computed(() => {
  const ticket = parseNumber(ticketMedio.value);
  return ticket > 0
    ? Number(metaVendasMensal.value / ticket / Number(taxaConversao.value/100))
    : 0;
});

onMounted(() => {
  metaVendasAnual.value = 1000000;
  ticketMedio.value = 221000;
});
</script>

<template>
  <div class="container mt-0 p-5 br-2 bg-white">
  <div class="w-container">
    <h1>Projeção de Resultados 2025</h1>
    <div class="w-dados row m-3">
      <div>
        <label class="form-label fs-5">Meta de Vendas Anual:</label>
        <!-- {{ metaVendasAnual }} -->
        <input v-money="Money" v-model="metaVendasAnual" class="form-control" />
      </div>
      <div class="w-full"><hr></div>
      <p>
        <strong>Meta de Vendas Mensal: </strong>
        <span class="fs-5">
            {{
                metaVendasMensal.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL",
                })
            }}
        </span>
      </p>
      <div class="w-full"><hr></div>
      <div class="form-group w-full mb-3">
        <label class="form-label fs-5">Ticket Médio Atual:</label>
        <input v-money="Money" v-model="ticketMedio" class="form-control" />
      </div>
      <div class="form-group w-full mb-3">
        <label class="form-label fs-5">Taxa de Conversão Atual (%):</label>
        <input type="number" v-model="taxaConversao" step="0.01" class="form-control" />
      </div>
      <div class="w-full"><hr></div>
      <p>
        <strong>Meta de Oportunidades ao Mês: </strong>
        <span class="fs-4 fw-bold" style="color: red">
            {{ metaOportunidadesMes.toFixed(2) }}
        </span>
      </p>
      
    </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  border-top-right-radius: 90px;
  border-bottom-right-radius: 90px;
  /* background: 
    linear-gradient(45deg, #ccc 25%, transparent 25%, transparent 75%, #ccc 75%, #ccc),
    linear-gradient(45deg, #ccc 25%, transparent 25%, transparent 75%, #ccc 75%, #ccc);
  background-size: 5px 5px;
  background-position: 0 0, 10px 10px; */
}
.w-container {
  max-width: 600px;
  margin: 20px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}
.w-dados p,
.dados label {
  font-size: 1.2em;
  margin: 10px 10px;
  display: block;
}
</style>
