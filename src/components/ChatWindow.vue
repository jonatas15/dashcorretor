<template>
  <div class="flex flex-col h-full border rounded-lg shadow p-4 bg-white">

    <!-- Área das mensagens -->
    <div
      ref="chatBody"
      class="flex-1 overflow-y-auto mb-3 flex flex-col gap-2 pr-2"
    >
      <MessageBubble
        v-for="(msg, index) in chatHistory"
        :key="index"
        :role="msg.role"
        :content="msg.content"
        style="color: black !important;"
      />

      <!-- indicador de carregamento -->
      <div v-if="loading" class="self-start text-gray-500 text-sm">
        Digitando...
      </div>
    </div>

    <!-- Campo inferior -->
    <form @submit.prevent="sendMessage" class="flex gap-2">
      <!-- <input
        v-model="input"
        type="text"
        placeholder="Digite sua mensagem..."
        class="flex-1 border rounded px-3 py-2"
        required
      /> -->
      <textarea
        v-model="input"
        rows="4"
        style="width: 100%;"
        placeholder="Digite sua mensagem..."
        class="flex-1 border rounded px-3 py-2 resize-none w-full"
        required
      ></textarea>
      <br>
      <button
        type="submit"
        class="px-4 py-2 btn btn-success w-full"
      >
        Enviar <i class="fas fa-paper-plane ml-1"></i>
      </button>
    </form>
  </div>
</template>

<script>
import MessageBubble from "./MessageBubble.vue";

export default {
  name: "ChatWindow",

  components: { MessageBubble },

  data() {
    return {
      input: "",
      chatHistory: [],
      loading: false,
    };
  },

  methods: {
    async sendMessage() {
      const userMsg = this.input.trim();
      if (!userMsg) return;

      // adiciona mensagem do usuário
      this.chatHistory.push({ role: "user", content: userMsg });
      this.input = "";
      this.loading = true;

      this.scrollToBottom();

      // chamada ao backend FastAPI
      try {
        const response = await fetch("http://0.0.0.0:8000/chat", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            message: userMsg,
            history: this.chatHistory,
          }),
        });

        const data = await response.json();

        this.chatHistory.push({
          role: "assistant",
          content: data.reply,
        });
      } catch (e) {
        this.chatHistory.push({
          role: "assistant",
          content: "❌ Erro ao conectar com o servidor.",
        });
      }

      this.loading = false;
      this.scrollToBottom();
    },

    scrollToBottom() {
      this.$nextTick(() => {
        const area = this.$refs.chatBody;
        area.scrollTop = area.scrollHeight;
      });
    },
  },
};
</script>

<style scoped>
/* máximo de compatibilidade sem Tailwind */
::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-thumb {
  background: #bbb;
  border-radius: 4px;
}
/** cor do botão */
.btn-success {
  background-color: #02244a;
  color: white;
}
.btn-success:hover {
  background-color: #021f3d;
  color: white;
}
/** aumentar a largura do chat */
.modal-dialog {
  max-width: 500px;
}
</style>
