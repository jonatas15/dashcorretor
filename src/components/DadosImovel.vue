<template>
  <section>
    <h2>Dados do Imóvel</h2>
    <ul>
      <li><strong>Endereço:</strong> {{ imovel.endereco }}</li>
      <li><strong>Bairro:</strong> {{ imovel.bairro }}</li>
      <li><strong>Área:</strong> {{ imovel.area }} m²</li>
      <li><strong>Dormitórios:</strong> {{ imovel.dormitorios }}</li>
      <li><strong>Banheiros:</strong> {{ imovel.banheiros }}</li>
      <li><strong>Vagas:</strong> {{ imovel.vagas }}</li>
      <li><strong>Ano:</strong> {{ imovel.ano }}</li>
      <li><strong>Posição solar:</strong> {{ imovel.posicaoSolar }}</li>
      <li><strong>Demanda:</strong> {{ imovel.demanda }}</li>
    </ul>
  </section>
</template>

<script setup>
defineProps({
  imovel: Object
})
</script>
