<template>
  <section>
    <h2>Plano de Marketing</h2>
    <ul>
      <li v-for="(item, i) in itens" :key="i">{{ item }}</li>
    </ul>
  </section>
</template>

<script setup>
defineProps({
  itens: Array
})
</script>
