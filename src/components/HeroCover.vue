<template>
  <section>
    <h1>
      Estudo Estratégico de Mercado<br>
      <span class="highlight">Plano de Divulgação do Imóvel</span>
    </h1>
    <p>Estudo realizado para {{ clientes }}</p>
  </section>
</template>

<script setup>
defineProps({
  clientes: String
})
</script>
