<template>
  <div class="container mt-5">
    <h2>Formulário de Pesquisa</h2>
    <form @submit.prevent="handleSubmit">
      <div class="row">
        <!-- Imobiliária -->
        <div class="col-md-3 mb-3">
          <label for="imobiliaria" class="form-label">Imobiliária</label>
          <input v-model="form.imobiliaria" type="text" id="imobiliaria" class="form-control" />
        </div>
        <!-- Estado -->
        <div class="col-md-3 mb-3">
          <label for="estado" class="form-label">Estado</label>
          <input v-model="form.estado" type="text" id="estado" class="form-control" />
        </div>
        <!-- Cidade -->
        <div class="col-md-3 mb-3">
          <label for="cidade" class="form-label">Cidade</label>
          <input v-model="form.cidade" type="text" id="cidade" class="form-control" />
        </div>
        <!-- Bairro -->
        <div class="col-md-3 mb-3">
          <label for="bairro" class="form-label">Bairro</label>
          <input v-model="form.bairro" type="text" id="bairro" class="form-control" />
        </div>
        <!-- Negócio -->
        <div class="col-md-3 mb-3">
          <label for="negocio" class="form-label">Negócio</label>
          <select v-model="form.negocio" id="negocio" class="form-select">
            <option value="" disabled>Selecione</option>
            <option value="venda">Venda</option>
            <option value="aluguel">Aluguel</option>
          </select>
        </div>
        <!-- Finalidade/Tipo -->
        <div class="col-md-3 mb-3">
          <label for="finalidade" class="form-label">Finalidade/Tipo</label>
          <select v-model="form.finalidade" id="finalidade" class="form-select">
            <option value="" disabled>Selecione</option>
            <option value="residencial">Residencial</option>
            <option value="comercial">Comercial</option>
          </select>
        </div>
        <!-- Valor -->
        <div class="col-md-3 mb-3">
          <label for="valor" class="form-label">Valor (R$)</label>
          <input v-model="form.valor" type="number" id="valor" class="form-control" />
        </div>
        <!-- Área -->
        <div class="col-md-3 mb-3">
          <label for="area" class="form-label">Área (m²)</label>
          <input v-model="form.area" type="number" id="area" class="form-control" />
        </div>
        <!-- Banheiros -->
        <div class="col-md-2 mb-3">
          <label for="banheiros" class="form-label">Banheiros</label>
          <input v-model="form.banheiros" type="number" id="banheiros" class="form-control" />
        </div>
        <!-- Dormitórios -->
        <div class="col-md-2 mb-3">
          <label for="dormitorios" class="form-label">Dormitórios</label>
          <input v-model="form.dormitorios" type="number" id="dormitorios" class="form-control" />
        </div>
        <!-- Garagens -->
        <div class="col-md-2 mb-3">
          <label for="garagens" class="form-label">Garagens</label>
          <input v-model="form.garagens" type="number" id="garagens" class="form-control" />
        </div>
        <!-- Salas -->
        <div class="col-md-2 mb-3">
          <label for="salas" class="form-label">Salas</label>
          <input v-model="form.salas" type="number" id="salas" class="form-control" />
        </div>
        <!-- Mobiliado -->
        <div class="col-md-2 mb-3">
          <label for="mobiliado" class="form-label">Mobiliado</label>
          <select v-model="form.mobiliado" id="mobiliado" class="form-select">
            <option value="" disabled>Selecione</option>
            <option value="sim">Sim</option>
            <option value="nao">Não</option>
          </select>
        </div>
        <!-- <div class="col-md-2 mb-3">
          <button type="button" class="btn btn-secondary" @click="resetForm">Limpar Campos</button>
          <button type="submit" class="btn btn-primary form-control">Filtrar</button>
        </div> -->
      </div>
      <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <button type="button" class="btn btn-secondary" @click="resetForm">Limpar Campos</button>
      </div>
    </form>

    <h2 class="mt-5">Resultados</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Imobiliária</th>
          <th>Estado</th>
          <th>Cidade</th>
          <th>Bairro</th>
          <th>Negócio</th>
          <th>Finalidade</th>
          <th>Valor</th>
          <th>Área</th>
          <th>Banheiros</th>
          <th>Dormitórios</th>
          <th>Garagens</th>
          <th>Salas</th>
          <th>Mobiliado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in filteredData" :key="index">
          <td>{{ item.imobiliaria }}</td>
          <td>{{ item.estado }}</td>
          <td>{{ item.cidade }}</td>
          <td>{{ item.bairro }}</td>
          <td>{{ item.negocio }}</td>
          <td>{{ item.finalidade }}</td>
          <td>{{ item.valor }}</td>
          <td>{{ item.area }}</td>
          <td>{{ item.banheiros }}</td>
          <td>{{ item.dormitorios }}</td>
          <td>{{ item.garagens }}</td>
          <td>{{ item.salas }}</td>
          <td>{{ item.mobiliado }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { reactive, computed } from "vue";

// Dados simulados
const data = reactive([
  {
    imobiliaria: "Imob A",
    estado: "SP",
    cidade: "São Paulo",
    bairro: "Centro",
    negocio: "venda",
    finalidade: "residencial",
    valor: 500000,
    area: 100,
    banheiros: 2,
    dormitorios: 3,
    garagens: 2,
    salas: 1,
    mobiliado: "sim",
  },
  {
    imobiliaria: "Imob B",
    estado: "RJ",
    cidade: "Rio de Janeiro",
    bairro: "Copacabana",
    negocio: "aluguel",
    finalidade: "comercial",
    valor: 3000,
    area: 80,
    banheiros: 1,
    dormitorios: 2,
    garagens: 1,
    salas: 2,
    mobiliado: "não",
  },
  {
    imobiliaria: "Imob C",
    estado: "RS",
    cidade: "Santa Maria",
    bairro: "Camobi",
    negocio: "aluguel",
    finalidade: "rural",
    valor: 2500,
    area: 180,
    banheiros: 2,
    dormitorios: 3,
    garagens: 2,
    salas: 3,
    mobiliado: "sim",
  },
  // Adicione mais dados conforme necessário
]);

const initialForm = reactive({
  imobiliaria: "",
  estado: "",
  cidade: "",
  bairro: "",
  negocio: "",
  finalidade: "",
  valor: null,
  area: null,
  banheiros: null,
  dormitorios: null,
  garagens: null,
  salas: null,
  mobiliado: "",
});

const form = reactive({ ...initialForm });

const filteredData = computed(() => {
  return data.filter((item) => {
    return (
      (!form.imobiliaria || item.imobiliaria.includes(form.imobiliaria)) &&
      (!form.estado || item.estado.includes(form.estado)) &&
      (!form.cidade || item.cidade.includes(form.cidade)) &&
      (!form.bairro || item.bairro.includes(form.bairro)) &&
      (!form.negocio || item.negocio === form.negocio) &&
      (!form.finalidade || item.finalidade === form.finalidade) &&
      (!form.valor || item.valor <= form.valor) &&
      (!form.area || item.area >= form.area) &&
      (!form.banheiros || item.banheiros >= form.banheiros) &&
      (!form.dormitorios || item.dormitorios >= form.dormitorios) &&
      (!form.garagens || item.garagens >= form.garagens) &&
      (!form.salas || item.salas >= form.salas) &&
      (!form.mobiliado || item.mobiliado === form.mobiliado)
    );
  });
});
// Reseta o formulário para o estado inicial
const resetForm = () => {
  Object.assign(form, { ...initialForm });
};
const handleSubmit = () => {
  console.log("Filtro aplicado:", form);
};
</script>

<style>
/* Adicione seus estilos personalizados aqui, se necessário */
</style>
