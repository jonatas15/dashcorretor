<template>
  <section>
    <p><strong>{{ corretor.nome }}</strong></p>
    <p>CRECI: {{ corretor.creci }}</p>
    <p>{{ corretor.telefone }} • {{ corretor.email }}</p>
  </section>
</template>

<script setup>
defineProps({
  corretor: Object
})
</script>
