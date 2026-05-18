<template>
  <main style="max-width:900px; margin:0 auto; padding:2.5rem 1.5rem;">

    <h1 style="color:white; font-size:1.8rem; font-weight:700; margin-bottom:2rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
      Mon espace acheteur
    </h1>

    <!-- Stats -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem;">
      <div style="background:rgba(79,70,229,0.85); border-radius:14px; padding:1.5rem; text-align:center; backdrop-filter:blur(6px);">
        <p style="font-size:2.2rem; font-weight:700; color:white;">{{ orders.length }}</p>
        <p style="font-size:0.8rem; color:rgba(255,255,255,0.85); text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Commandes totales</p>
      </div>
      <div style="background:rgba(22,163,74,0.85); border-radius:14px; padding:1.5rem; text-align:center; backdrop-filter:blur(6px);">
        <p style="font-size:2.2rem; font-weight:700; color:white;">{{ orders.filter(o => o.status === 'pending' || o.status === 'in_progress').length }}</p>
        <p style="font-size:0.8rem; color:rgba(255,255,255,0.85); text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">En cours</p>
      </div>
      <div style="background:rgba(30,30,30,0.75); border-radius:14px; padding:1.5rem; text-align:center; backdrop-filter:blur(6px);">
        <p style="font-size:2.2rem; font-weight:700; color:white;">{{ orders.filter(o => o.status === 'completed').length }}</p>
        <p style="font-size:0.8rem; color:rgba(255,255,255,0.85); text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Terminées</p>
      </div>
    </div>

    <!-- Commandes -->
    <h2 style="color:white; font-size:1.2rem; font-weight:600; margin-bottom:1rem; text-shadow:0 2px 8px rgba(0,0,0,0.5);">
      Mes commandes
    </h2>

    <div v-if="orders.length === 0" style="background:rgba(255,255,255,0.9); border-radius:14px; padding:2rem; text-align:center; color:#666;">
      Aucune commande pour le moment.
    </div>

    <div style="display:flex; flex-direction:column; gap:0.75rem;">
      <div v-for="order in orders" :key="order.id"
        style="background:rgba(255,255,255,0.95); border-radius:14px; padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; backdrop-filter:blur(6px);">
        <div>
          <p style="font-weight:600; color:#111; font-size:1rem;">{{ order.service.title }}</p>
          <p style="color:#888; font-size:0.82rem; margin-top:0.25rem;">{{ order.createdAt }}</p>
        </div>
        <div style="display:flex; align-items:center; gap:1rem;">
          <span style="font-weight:700; color:#111; font-size:1.05rem;">{{ order.total }} €</span>
          <span :style="badgeStyle(order.status)" style="padding:0.35rem 0.9rem; border-radius:20px; font-size:0.78rem; font-weight:600;">
            {{ statusLabel(order.status) }}
          </span>
        </div>
      </div>
    </div>

  </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { getMyOrders } from '../services/api'

const orders = ref<any[]>([])

onMounted(async () => {
  try {
    const res = await getMyOrders()
    orders.value = res.data
  } catch (e) {
    console.error(e)
  }
})

const badgeStyle = (status: string) => {
  if (status === 'completed') return 'background:#dcfce7; color:#166534;'
  if (status === 'pending') return 'background:#dbeafe; color:#1e40af;'
  if (status === 'in_progress') return 'background:#dbeafe; color:#1e40af;'
  return 'background:#fee2e2; color:#991b1b;'
}

const statusLabel = (status: string) => {
  if (status === 'completed') return 'Terminé'
  if (status === 'pending') return 'En cours'
  if (status === 'in_progress') return 'En cours'
  return 'Annulé'
}
</script>