<template>
  <div>
    <!-- Bouton flottant -->
    <button @click="toggleChat"
      style="position:fixed; bottom:2rem; right:2rem; width:60px; height:60px; border-radius:50%; background:linear-gradient(135deg,#4F46E5,#7C3AED); border:none; cursor:pointer; z-index:1000; display:flex; align-items:center; justify-content:center; font-size:1.6rem; box-shadow:0 4px 20px rgba(79,70,229,0.5);">
      {{ isOpen ? '✕' : '🤖' }}
    </button>

    <!-- Fenêtre chat -->
    <div v-if="isOpen"
      style="position:fixed; bottom:6rem; right:2rem; width:360px; background:rgba(255,255,255,0.97); border-radius:20px; z-index:1000; display:flex; flex-direction:column; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,0.2);">

      <!-- Header -->
      <div style="background:linear-gradient(135deg,#4F46E5,#7C3AED); padding:1rem 1.25rem; display:flex; align-items:center; gap:0.75rem;">
        <div style="width:36px; height:36px; background:rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">🤖</div>
        <div>
          <p style="color:white; font-weight:600; font-size:0.95rem; margin:0;">Assistant MarketHub</p>
          <p style="color:rgba(255,255,255,0.75); font-size:0.75rem; margin:0;">Ton conseiller formation personnel</p>
        </div>
      </div>

      <!-- Messages -->
      <div ref="messagesContainer" style="flex:1; overflow-y:auto; padding:1rem; display:flex; flex-direction:column; gap:0.75rem; max-height:350px;">
        <div v-for="(msg, i) in messages" :key="i"
          :style="msg.role === 'user' ? 'align-self:flex-end; background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; padding:0.65rem 1rem; border-radius:16px 16px 4px 16px; max-width:80%; font-size:0.88rem; line-height:1.5;' : 'align-self:flex-start; background:#f3f4f6; color:#111; padding:0.65rem 1rem; border-radius:16px 16px 16px 4px; max-width:85%; font-size:0.88rem; line-height:1.5;'">
          {{ msg.content }}
        </div>
        <div v-if="loading" style="align-self:flex-start; background:#f3f4f6; padding:0.65rem 1rem; border-radius:16px 16px 16px 4px; font-size:0.88rem; color:#888;">
          ✨ Réflexion en cours...
        </div>
      </div>

      <!-- Input -->
      <div style="padding:0.75rem; border-top:1px solid #eee; display:flex; gap:0.5rem;">
        <input
          v-model="userInput"
          @keyup.enter="sendMessage"
          placeholder="Ex: je veux apprendre le design..."
          style="flex:1; padding:0.65rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.85rem; outline:none;"
          @focus="e => e.target.style.borderColor='#4F46E5'"
          @blur="e => e.target.style.borderColor='#e5e7eb'"
        />
        <button @click="sendMessage" :disabled="loading"
          style="background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.65rem 1rem; border-radius:10px; cursor:pointer; font-size:0.9rem;">
          ➤
        </button>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, nextTick } from 'vue'

const isOpen = ref(false)
const userInput = ref('')
const loading = ref(false)
const messagesContainer = ref<HTMLElement | null>(null)

const messages = ref([
  { role: 'assistant', content: '👋 Salut ! Je suis ton conseiller formation sur MarketHub. Pour te proposer un parcours personnalisé, dis-moi : quel est ton domaine d\'intérêt ? (développement, design, marketing, rédaction...)' }
])

const toggleChat = () => {
  isOpen.value = !isOpen.value
}

const scrollToBottom = async () => {
  await nextTick()
  if (messagesContainer.value) {
    messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
  }
}

const sendMessage = async () => {
  if (!userInput.value.trim() || loading.value) return

  messages.value.push({ role: 'user', content: userInput.value })
  const userMsg = userInput.value
  userInput.value = ''
  loading.value = true
  await scrollToBottom()

  try {
    const response = await fetch('http://localhost:8000/api/agent', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        messages: messages.value.map(m => ({ role: m.role, content: m.content }))
      })
    })

    const data = await response.json()
    const reply = data.reply || 'Désolé, je n\'ai pas pu répondre.'
    messages.value.push({ role: 'assistant', content: reply })
  } catch (e) {
    messages.value.push({ role: 'assistant', content: '❌ Erreur de connexion.' })
  }

  loading.value = false
  await scrollToBottom()
}
</script>