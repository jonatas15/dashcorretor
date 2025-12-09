import rooms from './rooms.json'
import messages from './messages.json'

export async function getRooms() {
  return Promise.resolve(rooms)
}

export async function getMessages(roomId) {
  return Promise.resolve(messages.filter(m => m.room_id === roomId))
}

export async function sendMessage(roomId, text) {
  const msg = {
    id: Date.now(),
    room_id: roomId,
    sender: "Você",
    text,
    created_at: new Date().toISOString()
  }
  messages.push(msg)
  return Promise.resolve(msg)
}

export async function searchMessages(query) {
  if (!query) return Promise.resolve([])

  const q = query.toLowerCase()
  const result = messages.filter(m => m.text.toLowerCase().includes(q))

  return Promise.resolve(result)
}
