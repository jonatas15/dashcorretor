<template>
  <div
    class="p-3 mb-2 max-w-[80%] rounded-xl chat-message break-words chatbot-response"
    :class="role === 'user'
        ? 'bg-blue-600 text-white self-end'
        : 'bg-gray-200 text-gray-900 self-start'"
    v-html="formattedContent"
  >
  </div>
</template>

<script>
export default {
  name: "MessageBubble",
  props: {
    role: { type: String, required: true },
    content: { type: String, required: true },
  },
  computed: {
    formattedContent() {
      return this.content
        .replace(/\n\n/g, '</p><p>')
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/(\d+)\.\s/g, '<li style="margin-left: 20px;list-style: none">$1. ')
        .replace(
          /Quer que eu envie\?/g,
          '<div class="cta">Quer que eu envie?</div>'
        );
    }
  }
};
</script>

<style scoped>
/* Se quiser estilos extras, coloca aqui */
.chatbot-response {
  background: #f9fafb;
  border-left: 4px solid #4f46e5;
  padding: 16px 20px;
  border-radius: 8px;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  color: #111827;
  line-height: 1.6;
  text-align: justify;
}

.chatbot-response ol {
  margin: 12px 20px 12px 20px;
  list-style: none;
}

.chatbot-response li {
  margin-bottom: 12px;
  list-style: none;
}

.chatbot-response strong {
  color: #1f2937;
}

.chatbot-response .cta {
  margin-top: 16px;
  padding: 12px;
  background: #eef2ff;
  border-radius: 6px;
  font-weight: 500;
}
</style>
