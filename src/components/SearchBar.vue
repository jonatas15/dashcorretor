<template>
  <div>
    <input
      v-model="q"
      @keyup.enter="emitSearch"
      type="text"
      placeholder="Buscar..."
      class="w-full px-3 py-2 rounded bg-gray-800 text-white text-sm"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
const emit = defineEmits(["search"])
const q = ref('')

function emitSearch() {
  emit("search", q.value)
}
</script>
