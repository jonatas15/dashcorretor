<template>
  <!-- trocar classes para bootstrap -->
  <div class="flex flex-col h-full bg-gray-800 text-white bg-dark">
    <div class="p-4 text-lg font-bold border-b border-gray-700">
      Chat Interno
    </div>

    <SearchBar @search="emitSearch" class="p-2" />

    <div class="flex-1 overflow-y-auto">
      <div
        v-for="room in rooms"
        :key="room.id"
        @click="$emit('select', room)"
        class="p-3 cursor-pointer hover:bg-gray-700"
      >
        {{ room.name }}
      </div>
    </div>
  </div>
</template>

<script setup>
import SearchBar from "./SearchBar.vue";

const props = defineProps({
  rooms: Array,
});

const emit = defineEmits(["select", "search"]);

function emitSearch(q) {
  emit("search", q);
}
</script>
