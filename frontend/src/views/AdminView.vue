<template>
  <div style="max-width:1100px; margin:0 auto; padding:2rem 1.5rem;">

    <h1 style="color:white; font-size:1.8rem; font-weight:700; margin-bottom:0.5rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
      👑 Panel Administrateur
    </h1>
    <p style="color:rgba(255,255,255,0.7); margin-bottom:2rem;">Gestion complète de MarketHub</p>

    <!-- STATS -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem;">
      <div style="background:rgba(79,70,229,0.85); border-radius:14px; padding:1.5rem; text-align:center;">
        <p style="font-size:2.5rem; font-weight:700; color:white;">{{ stats.total_users }}</p>
        <p style="color:rgba(255,255,255,0.85); font-size:0.85rem; text-transform:uppercase; letter-spacing:1px;">Utilisateurs</p>
      </div>
      <div style="background:rgba(22,163,74,0.85); border-radius:14px; padding:1.5rem; text-align:center;">
        <p style="font-size:2.5rem; font-weight:700; color:white;">{{ stats.total_services }}</p>
        <p style="color:rgba(255,255,255,0.85); font-size:0.85rem; text-transform:uppercase; letter-spacing:1px;">Services</p>
      </div>
      <div style="background:rgba(30,30,30,0.75); border-radius:14px; padding:1.5rem; text-align:center;">
        <p style="font-size:2.5rem; font-weight:700; color:white;">{{ stats.total_orders }}</p>
        <p style="color:rgba(255,255,255,0.85); font-size:0.85rem; text-transform:uppercase; letter-spacing:1px;">Commandes</p>
      </div>
    </div>

    <!-- ONGLETS -->
    <div style="display:flex; gap:0.75rem; margin-bottom:1.5rem;">
      <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id"
        :style="activeTab === tab.id ? 'background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white;' : 'background:rgba(255,255,255,0.9); color:#4F46E5;'"
        style="padding:0.6rem 1.25rem; border:none; border-radius:10px; font-size:0.88rem; font-weight:600; cursor:pointer;">
        {{ tab.icon }} {{ tab.label }}
      </button>
    </div>

    <!-- UTILISATEURS -->
    <div v-if="activeTab === 'users'" style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem;">
      <h2 style="font-size:1.1rem; font-weight:700; color:#111; margin-bottom:1rem;">Utilisateurs</h2>
      <div style="display:flex; flex-direction:column; gap:0.75rem;">
        <div v-for="user in users" :key="user.id"
          style="display:flex; justify-content:space-between; align-items:center; padding:0.75rem 1rem; background:#f9fafb; border-radius:10px;">
          <div>
            <p style="font-weight:600; color:#111;">{{ user.username }}</p>
            <p style="color:#888; font-size:0.82rem;">{{ user.email }}</p>
          </div>
          <div style="display:flex; align-items:center; gap:0.75rem;">
            <span style="background:#EEF2FF; color:#4F46E5; font-size:0.75rem; padding:0.2rem 0.6rem; border-radius:20px; font-weight:600;">
              {{ user.roles.includes('ROLE_ADMIN') ? 'Admin' : 'User' }}
            </span>
            <button @click="deleteUser(user.id)"
              style="background:#fee2e2; color:#991b1b; border:none; padding:0.35rem 0.75rem; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
              Supprimer
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- SERVICES -->
    <div v-if="activeTab === 'services'" style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem;">
      <h2 style="font-size:1.1rem; font-weight:700; color:#111; margin-bottom:1rem;">Services</h2>
      <div style="display:flex; flex-direction:column; gap:0.75rem;">
        <div v-for="service in services" :key="service.id"
          style="display:flex; justify-content:space-between; align-items:center; padding:0.75rem 1rem; background:#f9fafb; border-radius:10px;">
          <div>
            <p style="font-weight:600; color:#111;">{{ service.title }}</p>
            <p style="color:#888; font-size:0.82rem;">{{ service.seller }} — {{ service.price }} €</p>
          </div>
          <div style="display:flex; gap:0.75rem;">
            <span :style="service.status === 'active' ? 'background:#dcfce7; color:#166534;' : 'background:#fee2e2; color:#991b1b;'"
              style="font-size:0.75rem; padding:0.2rem 0.6rem; border-radius:20px; font-weight:600;">
              {{ service.status }}
            </span>
            <button @click="deleteService(service.id)"
              style="background:#fee2e2; color:#991b1b; border:none; padding:0.35rem 0.75rem; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
              Supprimer
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- COMMANDES -->
    <div v-if="activeTab === 'orders'" style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem;">
      <h2 style="font-size:1.1rem; font-weight:700; color:#111; margin-bottom:1rem;">Commandes</h2>
      <div style="display:flex; flex-direction:column; gap:0.75rem;">
        <div v-for="order in orders" :key="order.id"
          style="display:flex; justify-content:space-between; align-items:center; padding:0.75rem 1rem; background:#f9fafb; border-radius:10px;">
          <div>
            <p style="font-weight:600; color:#111;">{{ order.service }}</p>
            <p style="color:#888; font-size:0.82rem;">Acheteur : {{ order.buyer }} — {{ order.createdAt }}</p>
          </div>
          <div style="display:flex; align-items:center; gap:0.75rem;">
            <span style="font-weight:700; color:#111;">{{ order.total }} €</span>
            <span :style="order.status === 'completed' ? 'background:#dcfce7; color:#166534;' : 'background:#dbeafe; color:#1e40af;'"
              style="font-size:0.75rem; padding:0.2rem 0.6rem; border-radius:20px; font-weight:600;">
              {{ order.status }}
            </span>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

const BASE = 'http://127.0.0.1:8000'
const activeTab = ref('users')
const tabs = [
  { id: 'users', icon: '👤', label: 'Utilisateurs' },
  { id: 'services', icon: '📦', label: 'Services' },
  { id: 'orders', icon: '🛒', label: 'Commandes' },
]

const stats = ref({ total_users: 0, total_services: 0, total_orders: 0 })
const users = ref([])
const services = ref([])
const orders = ref([])

const getHeaders = () => ({
  Authorization: `Bearer ${localStorage.getItem('token')}`
})

onMounted(async () => {
  try {
    const [statsRes, usersRes, servicesRes, ordersRes] = await Promise.all([
      axios.get(`${BASE}/api/admin/stats`, { headers: getHeaders() }),
      axios.get(`${BASE}/api/admin/users`, { headers: getHeaders() }),
      axios.get(`${BASE}/api/admin/services`, { headers: getHeaders() }),
      axios.get(`${BASE}/api/admin/orders`, { headers: getHeaders() }),
    ])
    stats.value = statsRes.data
    users.value = usersRes.data
    services.value = servicesRes.data
    orders.value = ordersRes.data
  } catch (e) {
    console.error(e)
  }
})

const deleteUser = async (id: number) => {
  if (!confirm('Supprimer cet utilisateur ?')) return
  await axios.delete(`${BASE}/api/admin/users/${id}`, { headers: getHeaders() })
  users.value = users.value.filter((u: any) => u.id !== id)
  stats.value.total_users--
}

const deleteService = async (id: number) => {
  if (!confirm('Supprimer ce service ?')) return
  await axios.delete(`${BASE}/api/admin/services/${id}`, { headers: getHeaders() })
  services.value = services.value.filter((s: any) => s.id !== id)
  stats.value.total_services--
}
</script>