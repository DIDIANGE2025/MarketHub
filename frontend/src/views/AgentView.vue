<template>
  <div style="max-width:900px; margin:2rem auto; padding:1.5rem;">

    <h1 style="color:white; font-size:1.8rem; font-weight:700; margin-bottom:0.5rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
      🤖 MarketHub AI Advisor
    </h1>
    <p style="color:rgba(255,255,255,0.8); font-size:0.9rem; margin-bottom:2rem;">
      Ton assistant IA personnel — conseils, descriptions, recommandations
    </p>

    <!-- 3 ONGLETS -->
    <div style="display:flex; gap:0.75rem; margin-bottom:2rem;">
      <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id"
        :style="activeTab === tab.id ? 'background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white;' : 'background:rgba(255,255,255,0.9); color:#4F46E5;'"
        style="padding:0.6rem 1.25rem; border:none; border-radius:10px; font-size:0.88rem; font-weight:600; cursor:pointer;">
        {{ tab.icon }} {{ tab.label }}
      </button>
    </div>

    <!-- ONGLET 1 — Conseiller formation -->
    <div v-if="activeTab === 'conseiller'">
      <div ref="chatBox" style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.25rem; height:380px; overflow-y:auto; margin-bottom:1rem; display:flex; flex-direction:column; gap:0.75rem;">
        <div v-for="(msg, i) in chatMessages" :key="i"
          :style="msg.role === 'user' ? 'align-self:flex-end; background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; padding:0.65rem 1rem; border-radius:16px 16px 4px 16px; max-width:80%; font-size:0.88rem; line-height:1.5;' : 'align-self:flex-start; background:#f3f4f6; color:#111; padding:0.65rem 1rem; border-radius:16px 16px 16px 4px; max-width:85%; font-size:0.88rem; line-height:1.5;'">
          {{ msg.content }}
        </div>
        <div v-if="loadingChat" style="align-self:flex-start; background:#f3f4f6; padding:0.65rem 1rem; border-radius:16px; font-size:0.88rem; color:#888;">
          ✨ Reflexion en cours...
        </div>
      </div>
      <div style="display:flex; gap:0.75rem;">
        <input v-model="chatInput" @keyup.enter="sendChat"
          placeholder="Ex: je veux apprendre le developpement web..."
          style="flex:1; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.9rem; outline:none; background:rgba(255,255,255,0.95);"
          @focus="e => e.target.style.borderColor='#4F46E5'"
          @blur="e => e.target.style.borderColor='#e5e7eb'" />
        <button @click="sendChat" :disabled="loadingChat"
          style="background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.75rem 1.5rem; border-radius:10px; font-size:0.9rem; font-weight:600; cursor:pointer;">
          Envoyer
        </button>
      </div>
    </div>

    <!-- ONGLET 2 — Generateur description -->
    <div v-if="activeTab === 'description'" style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem;">
      <h2 style="font-size:1.1rem; font-weight:700; color:#111; margin-bottom:1.25rem;">
        Genere une description professionnelle pour ton service
      </h2>
      <div style="display:flex; flex-direction:column; gap:1rem; margin-bottom:1.25rem;">
        <div>
          <label style="display:block; font-size:0.82rem; font-weight:600; color:#444; margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.5px;">Tes competences</label>
          <input v-model="descCompetences" placeholder="Ex: creation de sites web en HTML CSS JavaScript..."
            style="width:100%; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.9rem; outline:none; box-sizing:border-box;"
            @focus="e => e.target.style.borderColor='#4F46E5'"
            @blur="e => e.target.style.borderColor='#e5e7eb'" />
        </div>
        <div style="display:flex; gap:1rem;">
          <div style="flex:1;">
            <label style="display:block; font-size:0.82rem; font-weight:600; color:#444; margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.5px;">Categorie</label>
            <select v-model="descCategorie"
              style="width:100%; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.9rem; outline:none; background:white;">
              <option value="Developpement">Developpement</option>
              <option value="Design">Design</option>
              <option value="Redaction">Redaction</option>
              <option value="Marketing">Marketing</option>
            </select>
          </div>
          <div style="flex:1;">
            <label style="display:block; font-size:0.82rem; font-weight:600; color:#444; margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.5px;">Prix (euros)</label>
            <input v-model="descPrix" type="number" placeholder="50"
              style="width:100%; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.9rem; outline:none; box-sizing:border-box;"
              @focus="e => e.target.style.borderColor='#4F46E5'"
              @blur="e => e.target.style.borderColor='#e5e7eb'" />
          </div>
        </div>
      </div>
      <button @click="genererDescription" :disabled="loadingDesc"
        style="width:100%; background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.85rem; border-radius:10px; font-size:0.95rem; font-weight:600; cursor:pointer; margin-bottom:1rem;">
        {{ loadingDesc ? 'Generation en cours...' : 'Generer la description' }}
      </button>
      <div v-if="descResult" style="background:#EEF2FF; border-radius:12px; padding:1.25rem; color:#111; font-size:0.95rem; line-height:1.7;">
        <p style="font-weight:600; color:#4F46E5; margin-bottom:0.5rem;">Description generee :</p>
        <p>{{ descResult }}</p>
        <button @click="copyDescription"
          style="margin-top:0.75rem; background:white; color:#4F46E5; border:2px solid #4F46E5; padding:0.4rem 1rem; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
          Copier
        </button>
      </div>
    </div>

    <!-- ONGLET 3 — Matching -->
    <div v-if="activeTab === 'matching'" style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem;">
      <h2 style="font-size:1.1rem; font-weight:700; color:#111; margin-bottom:1.25rem;">
        Decris ton besoin — je trouve les meilleurs services pour toi
      </h2>
      <textarea v-model="matchingBesoin"
        placeholder="Ex: j'ai besoin d'un site web simple pour mon association, budget limite, livraison rapide..."
        style="width:100%; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.9rem; outline:none; box-sizing:border-box; height:100px; resize:vertical; font-family:inherit;"
        @focus="e => e.target.style.borderColor='#4F46E5'"
        @blur="e => e.target.style.borderColor='#e5e7eb'"></textarea>
      <button @click="faireMatching" :disabled="loadingMatch"
        style="width:100%; background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.85rem; border-radius:10px; font-size:0.95rem; font-weight:600; cursor:pointer; margin-top:1rem; margin-bottom:1rem;">
        {{ loadingMatch ? 'Analyse en cours...' : 'Trouver les meilleurs services' }}
      </button>
      <div v-if="matchResult">
        <p style="font-weight:600; color:#4F46E5; margin-bottom:0.75rem;">Recommandations IA :</p>
        <div v-for="rec in matchResult.recommandations" :key="rec.id"
          style="background:#f9fafb; border-radius:12px; padding:1rem; margin-bottom:0.75rem; display:flex; justify-content:space-between; align-items:center; cursor:pointer;"
          @click="$router.push(`/services/${rec.id}`)">
          <div>
            <p style="font-weight:600; color:#111; font-size:0.95rem;">Service #{{ rec.id }}</p>
            <p style="color:#666; font-size:0.85rem; margin-top:0.25rem;">{{ rec.raison }}</p>
          </div>
          <span style="background:#EEF2FF; color:#4F46E5; font-weight:700; padding:0.3rem 0.75rem; border-radius:20px; font-size:0.9rem;">
            {{ rec.score }}%
          </span>
        </div>
        <div v-if="matchResult.conseil" style="background:#EEF2FF; border-radius:12px; padding:1rem; margin-top:0.75rem;">
          <p style="color:#4F46E5; font-size:0.9rem; font-weight:600;">Conseil IA :</p>
          <p style="color:#555; font-size:0.88rem; margin-top:0.25rem;">{{ matchResult.conseil }}</p>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, nextTick } from 'vue'
import axios from 'axios'

const activeTab = ref('conseiller')
const tabs = [
  { id: 'conseiller', icon: '🎓', label: 'Conseiller formation' },
  { id: 'description', icon: '✍️', label: 'Generateur description' },
  { id: 'matching', icon: '🎯', label: 'Matching intelligent' },
]

const BASE = 'http://127.0.0.1:8000'

// ONGLET 1 — Chat conseiller
const chatMessages = ref([
  { role: 'assistant', content: '👋 Salut ! Je suis ton conseiller formation MarketHub. Quel est ton domaine d\'interet ? (developpement, design, marketing, redaction...)' }
])
const chatInput = ref('')
const loadingChat = ref(false)
const chatBox = ref<HTMLElement | null>(null)

const sendChat = async () => {
  if (!chatInput.value.trim() || loadingChat.value) return
  chatMessages.value.push({ role: 'user', content: chatInput.value })
  chatInput.value = ''
  loadingChat.value = true
  await nextTick()
  if (chatBox.value) chatBox.value.scrollTop = chatBox.value.scrollHeight

  try {
    const res = await axios.post(`${BASE}/api/agent/conseiller`, {
      messages: chatMessages.value.map(m => ({ role: m.role, content: m.content }))
    })
    chatMessages.value.push({ role: 'assistant', content: res.data.reply })
  } catch {
    chatMessages.value.push({ role: 'assistant', content: 'Erreur de connexion.' })
  }
  loadingChat.value = false
  await nextTick()
  if (chatBox.value) chatBox.value.scrollTop = chatBox.value.scrollHeight
}

// ONGLET 2 — Description
const descCompetences = ref('')
const descCategorie = ref('Developpement')
const descPrix = ref('')
const descResult = ref('')
const loadingDesc = ref(false)

const genererDescription = async () => {
  if (!descCompetences.value || loadingDesc.value) return
  loadingDesc.value = true
  try {
    const res = await axios.post(`${BASE}/api/agent/description`, {
      competences: descCompetences.value,
      categorie: descCategorie.value,
      prix: descPrix.value
    })
    descResult.value = res.data.description
  } catch {
    descResult.value = 'Erreur de connexion.'
  }
  loadingDesc.value = false
}

const copyDescription = () => {
  navigator.clipboard.writeText(descResult.value)
  alert('Description copiee !')
}

// ONGLET 3 — Matching
const matchingBesoin = ref('')
const matchResult = ref<any>(null)
const loadingMatch = ref(false)

const faireMatching = async () => {
  if (!matchingBesoin.value || loadingMatch.value) return
  loadingMatch.value = true
  try {
    const servicesRes = await axios.get(`${BASE}/api/services`)
    const res = await axios.post(`${BASE}/api/agent/matching`, {
      besoin: matchingBesoin.value,
      services: servicesRes.data
    })
    matchResult.value = res.data
  } catch {
    matchResult.value = { conseil: 'Erreur de connexion.' }
  }
  loadingMatch.value = false
}
</script>