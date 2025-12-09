<template>
  <div class="w-full h-full flex">
    <div class="row">
      <div class="col-md-3">
        <Sidebar :rooms="rooms" @select="selectRoom" @search="runSearch" />
      </div>
      <div class="col-md-9">
        <div class="flex-1">
          <ChatWindow :messages="currentMessages" @send="send" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Sidebar from "../components/Sidebar.vue";
import ChatWindow from "../components/ChatWindow.vue";

import {
  getRooms,
  getMessages,
  sendMessage,
  searchMessages,
} from "../mock/api";

const rooms = ref([]);
const currentRoom = ref(null);
const currentMessages = ref([]);

onMounted(async () => {
  rooms.value = await getRooms();
});

async function selectRoom(room) {
  currentRoom.value = room;
  currentMessages.value = await getMessages(room.id);
}

async function send(text) {
  if (!currentRoom.value) return;
  const msg = await sendMessage(currentRoom.value.id, text);
  currentMessages.value.push(msg);
}

async function runSearch(query) {
  currentMessages.value = await searchMessages(query);
}
</script>
