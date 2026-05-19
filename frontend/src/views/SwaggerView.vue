<template>
  <div style="max-width:1000px; margin:0 auto; padding:2rem 1.5rem;">

    <h1 style="color:white; font-size:1.8rem; font-weight:700; margin-bottom:0.5rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
      📚 Documentation API — MarketHub
    </h1>
    <p style="color:rgba(255,255,255,0.7); margin-bottom:2rem;">
      Version 1.0 — Base URL : http://127.0.0.1:8000
    </p>

    <!-- FILTRE -->
    <div style="display:flex; gap:0.75rem; margin-bottom:2rem; flex-wrap:wrap;">
      <button v-for="cat in categories" :key="cat.id" @click="activecat = cat.id"
        :style="activecat === cat.id ? 'background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white;' : 'background:rgba(255,255,255,0.9); color:#4F46E5;'"
        style="padding:0.5rem 1rem; border:none; border-radius:8px; font-size:0.85rem; font-weight:600; cursor:pointer;">
        {{ cat.icon }} {{ cat.label }}
      </button>
    </div>

    <!-- ENDPOINTS -->
    <div style="display:flex; flex-direction:column; gap:1rem;">
      <div v-for="endpoint in filteredEndpoints" :key="endpoint.id"
        style="background:rgba(255,255,255,0.95); border-radius:14px; overflow:hidden;">

        <!-- Header -->
        <div @click="toggle(endpoint.id)"
          style="display:flex; align-items:center; gap:1rem; padding:1rem 1.25rem; cursor:pointer;">
          <span :style="methodColor(endpoint.method)"
            style="padding:0.3rem 0.75rem; border-radius:6px; font-size:0.8rem; font-weight:700; font-family:monospace; min-width:70px; text-align:center;">
            {{ endpoint.method }}
          </span>
          <span style="font-family:monospace; font-size:0.9rem; color:#111; font-weight:600;">
            {{ endpoint.url }}
          </span>
          <span style="color:#666; font-size:0.85rem; margin-left:auto;">
            {{ endpoint.description }}
          </span>
          <span :style="endpoint.auth ? 'background:#FEF3C7; color:#B45309;' : 'background:#DCFCE7; color:#166534;'"
            style="font-size:0.75rem; font-weight:600; padding:0.2rem 0.6rem; border-radius:20px;">
            {{ endpoint.auth ? '🔒 Auth' : '🌐 Public' }}
          </span>
        </div>

        <!-- Detail -->
        <div v-if="openId === endpoint.id"
          style="border-top:1px solid #e5e7eb; padding:1.25rem; background:#f9fafb;">

          <div v-if="endpoint.body" style="margin-bottom:1rem;">
            <p style="font-size:0.82rem; font-weight:600; color:#444; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.5rem;">Body (JSON)</p>
            <pre style="background:#111; color:#10b981; padding:1rem; border-radius:8px; font-size:0.85rem; overflow-x:auto;">{{ endpoint.body }}</pre>
          </div>

          <div style="margin-bottom:1rem;">
            <p style="font-size:0.82rem; font-weight:600; color:#444; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.5rem;">Reponse</p>
            <pre style="background:#111; color:#60a5fa; padding:1rem; border-radius:8px; font-size:0.85rem; overflow-x:auto;">{{ endpoint.response }}</pre>
          </div>

          <div v-if="endpoint.auth" style="background:#FEF3C7; border-radius:8px; padding:0.75rem; font-size:0.85rem; color:#B45309;">
            🔒 Requiert un token JWT dans le header : Authorization: Bearer TOKEN
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const activecat = ref('all')
const openId = ref<string | null>(null)

const toggle = (id: string) => {
  openId.value = openId.value === id ? null : id
}

const categories = [
  { id: 'all', icon: '📋', label: 'Tous' },
  { id: 'auth', icon: '🔐', label: 'Auth' },
  { id: 'services', icon: '📦', label: 'Services' },
  { id: 'orders', icon: '🛒', label: 'Commandes' },
  { id: 'agent', icon: '🤖', label: 'Agent IA' },
  { id: 'admin', icon: '👑', label: 'Admin' },
]

const methodColor = (method: string) => {
  const colors: any = {
    GET: 'background:#DCFCE7; color:#166534;',
    POST: 'background:#DBEAFE; color:#1e40af;',
    PUT: 'background:#FEF3C7; color:#B45309;',
    DELETE: 'background:#FEE2E2; color:#991b1b;',
  }
  return colors[method] || ''
}

const endpoints = [
  {
    id: 'register', category: 'auth', method: 'POST',
    url: '/api/auth/register', description: 'Creer un compte', auth: false,
    body: `{
  "email": "user@test.com",
  "password": "test1234",
  "username": "MonPseudo"
}`,
    response: `{
  "message": "Compte cree avec succes",
  "user": { "id": 1, "email": "user@test.com", "username": "MonPseudo" }
}`
  },
  {
    id: 'login', category: 'auth', method: 'POST',
    url: '/api/auth/login', description: 'Se connecter', auth: false,
    body: `{
  "email": "user@test.com",
  "password": "test1234"
}`,
    response: `{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."
}`
  },
  {
    id: 'services-list', category: 'services', method: 'GET',
    url: '/api/services', description: 'Lister les services', auth: false,
    body: null,
    response: `[
  { "id": 1, "title": "Cours de maths", "price": 25, "status": "active",
    "seller": { "id": 4, "username": "Vendeur1" } }
]`
  },
  {
    id: 'service-show', category: 'services', method: 'GET',
    url: '/api/services/{id}', description: 'Voir un service', auth: false,
    body: null,
    response: `{
  "id": 1, "title": "Cours de maths", "price": 25,
  "description": "...", "seller": { "username": "Vendeur1" }
}`
  },
  {
    id: 'service-create', category: 'services', method: 'POST',
    url: '/api/services', description: 'Creer un service', auth: true,
    body: `{
  "title": "Mon service",
  "description": "Description du service",
  "price": 50
}`,
    response: `{ "message": "Service cree", "id": 5 }`
  },
  {
    id: 'service-update', category: 'services', method: 'PUT',
    url: '/api/services/{id}', description: 'Modifier un service', auth: true,
    body: `{
  "title": "Nouveau titre",
  "price": 35
}`,
    response: `{ "message": "Service mis a jour", "id": 1 }`
  },
  {
    id: 'service-delete', category: 'services', method: 'DELETE',
    url: '/api/services/{id}', description: 'Supprimer un service', auth: true,
    body: null,
    response: `{ "message": "Service supprime" }`
  },
  {
    id: 'order-create', category: 'orders', method: 'POST',
    url: '/api/orders', description: 'Passer une commande', auth: true,
    body: `{ "service_id": 1 }`,
    response: `{
  "message": "Commande creee", "id": 3,
  "status": "pending", "total": 25
}`
  },
  {
    id: 'order-my', category: 'orders', method: 'GET',
    url: '/api/orders/my', description: 'Mes commandes', auth: true,
    body: null,
    response: `[
  { "id": 1, "status": "pending", "total": 25,
    "service": { "title": "Cours de maths" } }
]`
  },
  {
    id: 'order-cancel', category: 'orders', method: 'PUT',
    url: '/api/orders/{id}/cancel', description: 'Annuler une commande', auth: true,
    body: null,
    response: `{ "message": "Commande annulee", "id": 1 }`
  },
  {
    id: 'agent-conseiller', category: 'agent', method: 'POST',
    url: '/api/agent/conseiller', description: 'Conseiller formation', auth: false,
    body: `{
  "messages": [{ "role": "user", "content": "je veux apprendre le dev web" }]
}`,
    response: `{ "reply": "Super choix ! Quel est ton budget ?" }`
  },
  {
    id: 'agent-description', category: 'agent', method: 'POST',
    url: '/api/agent/description', description: 'Generer description', auth: false,
    body: `{
  "competences": "creation de site web",
  "categorie": "Developpement",
  "prix": "50"
}`,
    response: `{ "description": "Expert en Developpement avec des competences..." }`
  },
  {
    id: 'agent-matching', category: 'agent', method: 'POST',
    url: '/api/agent/matching', description: 'Matching services', auth: false,
    body: `{
  "besoin": "site web pas cher",
  "services": []
}`,
    response: `{
  "recommandations": [{ "id": 1, "raison": "Adapte", "score": 95 }],
  "conseil": "Commencez par ce service !"
}`
  },
  {
    id: 'admin-stats', category: 'admin', method: 'GET',
    url: '/api/admin/stats', description: 'Statistiques globales', auth: true,
    body: null,
    response: `{
  "total_users": 7,
  "total_services": 4,
  "total_orders": 8
}`
  },
  {
    id: 'admin-users', category: 'admin', method: 'GET',
    url: '/api/admin/users', description: 'Tous les utilisateurs', auth: true,
    body: null,
    response: `[
  { "id": 1, "email": "user@test.com", "username": "TestUser", "roles": ["ROLE_USER"] }
]`
  },
  {
    id: 'admin-delete-user', category: 'admin', method: 'DELETE',
    url: '/api/admin/users/{id}', description: 'Supprimer un utilisateur', auth: true,
    body: null,
    response: `{ "message": "Utilisateur supprime" }`
  },
  {
    id: 'admin-services', category: 'admin', method: 'GET',
    url: '/api/admin/services', description: 'Tous les services', auth: true,
    body: null,
    response: `[
  { "id": 1, "title": "Cours de maths", "price": 25, "seller": "Vendeur1" }
]`
  },
  {
    id: 'admin-orders', category: 'admin', method: 'GET',
    url: '/api/admin/orders', description: 'Toutes les commandes', auth: true,
    body: null,
    response: `[
  { "id": 1, "status": "pending", "total": 25, "buyer": "testuser" }
]`
  },
]

const filteredEndpoints = computed(() =>
  activecat.value === 'all'
    ? endpoints
    : endpoints.filter(e => e.category === activecat.value)
)
</script>