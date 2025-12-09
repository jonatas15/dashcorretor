<template>
  <div
    class="p-3 mb-2 max-w-[80%] rounded-xl"
    :class="role === 'user'
        ? 'bg-blue-600 text-white self-end'
        : 'bg-gray-200 text-gray-900 self-start'"
  >
    <p class="whitespace-pre-wrap">{{ content }}</p>
  </div>
</template>

<script>
export default {
  name: "MessageBubble",
  props: {
    role: { type: String, required: true },
    content: { type: String, required: true },
  },
};
</script>

<style scoped>
/* Se quiser estilos extras, coloca aqui */
</style>
