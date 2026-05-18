<template>
  <div style="max-width:700px; margin:2rem auto; padding:1.5rem;">
    
    <h1 style="color:white; font-size:1.5rem; font-weight:700; margin-bottom:0.5rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
      💬 Messagerie temps réel
    </h1>
    <p v-if="vendeur" style="color:rgba(255,255,255,0.8); font-size:0.9rem; margin-bottom:1.5rem;">
      Conversation avec <strong>{{ vendeur }}</strong>
    </p>

    <!-- Fenêtre messages -->
    <div ref="messagesBox" style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.25rem; height:400px; overflow-y:auto; margin-bottom:1rem; display:flex; flex-direction:column; gap:0.75rem;">
      <div v-if="messages.length === 0" style="text-align:center; color:#888; margin:auto;">
        En attente de messages...
      </div>
      <div v-for="(msg, i) in messages" :key="i"
        :style="msg.type === 'sent' ? 'align-self:flex-end; background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; padding:0.65rem 1rem; border-radius:16px 16px 4px 16px; max-width:80%; font-size:0.9rem;' : msg.type === 'system' ? 'align-self:center; background:#f3f4f6; color:#888; padding:0.4rem 0.75rem; border-radius:20px; font-size:0.8rem;' : 'align-self:flex-start; background:#f3f4f6; color:#111; padding:0.65rem 1rem; border-radius:16px 16px 16px 4px; max-width:80%; font-size:0.9rem;'">
        {{ msg.text }}
      </div>
    </div>

    <!-- Statut connexion -->
    <div style="margin-bottom:0.75rem;">
      <span :style="connected ? 'background:#dcfce7; color:#166534;' : 'background:#fee2e2; color:#991b1b;'"
        style="font-size:0.78rem; font-weight:600; padding:0.3rem 0.75rem; border-radius:20px;">
        {{ connected ? '🟢 Connecté' : '🔴 Déconnecté' }}
      </span>
    </div>

    <!-- Input -->
    <div style="display:flex; gap:0.75rem;">
      <input v-model="newMessage" @keyup.enter="sendMessage"
        placeholder="Tapez votre message..."
        style="flex:1; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.95rem; outline:none; background:rgba(255,255,255,0.95);"
        @focus="e => e.target.style.borderColor='#4F46E5'"
        @blur="e => e.target.style.borderColor='#e5e7eb'" />
      <button @click="sendMessage"
        style="background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.75rem 1.5rem; border-radius:10px; font-size:0.95rem; font-weight:600; cursor:pointer;">
        Envoyer
      </button>
    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const vendeur = ref(route.query.vendeur as string || 'Vendeur')
const messages = ref<{text: string, type: string}[]>([])
const newMessage = ref('')
const connected = ref(false)
const messagesBox = ref<HTMLElement | null>(null)
let ws: WebSocket | null = null

onMounted(() => {
  ws = new WebSocket('ws://localhost:8080')
  
  ws.onopen = () => {
    connected.value = true
    messages.value.push({ text: `✅ Connecté — conversation avec ${vendeur.value}`, type: 'system' })
  }

  ws.onmessage = (e) => {
    messages.value.push({ text: `${vendeur.value}: ${e.data.replace('📨 ', '')}`, type: 'received' })
    scrollToBottom()
  }

  ws.onclose = () => {
    connected.value = false
    messages.value.push({ text: '❌ Déconnecté du serveur', type: 'system' })
  }
})

onUnmounted(() => {
  ws?.close()
})

const sendMessage = () => {
  if (!newMessage.value.trim() || !ws) return
  messages.value.push({ text: `Moi: ${newMessage.value}`, type: 'sent' })
  ws.send(newMessage.value)
  newMessage.value = ''
  scrollToBottom()
}

const scrollToBottom = async () => {
  await nextTick()
  if (messagesBox.value) {
    messagesBox.value.scrollTop = messagesBox.value.scrollHeight
  }
}
</script>