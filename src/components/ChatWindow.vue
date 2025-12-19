<template>
  <div class="flex flex-col h-full border rounded-lg shadow p-4 bg-white w-full h-full card">
    <div class="card-title">Assistente Virtual Avantor</div>
    <div class="card-body">
    <!-- Área das mensagens -->
    <div
      ref="chatBody"
      class="flex-1 overflow-y-auto mb-3 flex flex-col gap-2 pr-2 h-full"
    >
      <MessageBubble
        v-for="(msg, index) in chatHistory"
        :key="index"
        :role="msg.role"
        :content="msg.content"
        style="color: black !important;"
      />

      <!-- <MessageBubble
        :content="'Bom dia! Para fazer um bom lead, especialmente na área imobiliária, é importante seguir algumas estratégias que ajudam a captar contatos qualificados e com maior potencial de venda. Aqui vão algumas dicas baseadas no processo comercial da Avantor: 1. **Ofereça conteúdo relevante**: Utilize anúncios, posts em redes sociais e portais imobiliários que despertem o interesse do seu público-alvo. Apresente imóveis ou temas que sejam atraentes para quem está procurando investir em imóveis. 2. **Use uma abordagem consultiva no contato inicial**: Ao captar o lead, não parta direto para a venda. Procure entender as necessidades, desejos e desafios do cliente. Isso cria confiança e o posiciona como um consultor, não apenas um vendedor. 3. **Captação e pré-atendimento estruturado**: Depois de captar o lead, atue rapidamente, de preferência com uma ligação via WhatsApp para estabelecer conexão e iniciar uma conversa consultiva. Caso não atenda, envie mensagens e faça cadências de contato a cada 24 horas, sempre buscando abrir diálogo. 4. **Qualificação do lead através de perguntas**: Pergunte sobre o perfil do imóvel desejado e o que é prioridade para o cliente. Isso ajuda a direcionar melhor as ofertas e aumenta as chances de conversão. 5. **Persistência inteligente**: Não desista diante da ausência de respostas rápidas. Continue se comunicando com mensagens estratégicas para lembrar o lead sem ser inconveniente. Lembre-se: a venda é uma consequência de um processo bem conduzido, onde o objetivo principal é entender e ajudar o cliente. Se quiser, posso te ajudar com scripts e fluxogramas para estruturar esse processo com mais eficiência! Quer que eu envie?'"
        role="assistant"
        class="chatbot-response"
      /> -->

      <!-- indicador de carregamento -->
      <div v-if="loading" class="self-start text-gray-500 text-sm">
        Digitando...
      </div>
    </div>

    <!-- Campo inferior -->
    <form @submit.prevent="sendMessage" class="flex gap-2" id="formulario-modal-chat">
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
.chatbot-response {
  background: #f9fafb;
  border-left: 4px solid #4f46e5;
  padding: 16px 20px;
  border-radius: 8px;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  color: #111827;
  line-height: 1.6;
}

.chatbot-response ol {
  margin: 12px 0 12px 20px;
}

.chatbot-response li {
  margin-bottom: 12px;
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
