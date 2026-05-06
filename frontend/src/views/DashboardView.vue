<template>
  <main style="max-width:900px; margin:0 auto; padding:2.5rem 1.5rem;">

    <h1 style="color:white; font-size:1.8rem; font-weight:700; margin-bottom:2rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
      Mon espace acheteur
    </h1>

    <!-- Stats -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem;">
      <div style="background:rgba(79,70,229,0.85); border-radius:14px; padding:1.5rem; text-align:center; backdrop-filter:blur(6px);">
        <p style="font-size:2.2rem; font-weight:700; color:white;">3</p>
        <p style="font-size:0.8rem; color:rgba(255,255,255,0.85); text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Commandes totales</p>
      </div>
      <div style="background:rgba(22,163,74,0.85); border-radius:14px; padding:1.5rem; text-align:center; backdrop-filter:blur(6px);">
        <p style="font-size:2.2rem; font-weight:700; color:white;">1</p>
        <p style="font-size:0.8rem; color:rgba(255,255,255,0.85); text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">En cours</p>
      </div>
      <div style="background:rgba(30,30,30,0.75); border-radius:14px; padding:1.5rem; text-align:center; backdrop-filter:blur(6px);">
        <p style="font-size:2.2rem; font-weight:700; color:white;">2</p>
        <p style="font-size:0.8rem; color:rgba(255,255,255,0.85); text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Terminées</p>
      </div>
    </div>

    <!-- Commandes -->
    <h2 style="color:white; font-size:1.2rem; font-weight:600; margin-bottom:1rem; text-shadow:0 2px 8px rgba(0,0,0,0.5);">
      Mes commandes
    </h2>

    <div style="display:flex; flex-direction:column; gap:0.75rem;">
      <div v-for="order in mockOrders" :key="order.id"
        style="background:rgba(255,255,255,0.95); border-radius:14px; padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; backdrop-filter:blur(6px);">
        <div>
          <p style="font-weight:600; color:#111; font-size:1rem;">{{ order.title }}</p>
          <p style="color:#888; font-size:0.82rem; margin-top:0.25rem;">{{ order.date }}</p>
        </div>
        <div style="display:flex; align-items:center; gap:1rem;">
          <span style="font-weight:700; color:#111; font-size:1.05rem;">{{ order.price }} €</span>
          <span :style="badgeStyle(order.status)" style="padding:0.35rem 0.9rem; border-radius:20px; font-size:0.78rem; font-weight:600;">
            {{ order.statusLabel }}
          </span>
        </div>
      </div>
    </div>

  </main>
</template>

<script setup lang="ts">
const mockOrders = [
  { id: 1, title: 'Cours JavaScript débutant', date: '2 mai 2026', price: 29, status: 'completed', statusLabel: 'Terminé' },
  { id: 2, title: 'Design UI/UX Figma', date: '4 mai 2026', price: 49, status: 'in_progress', statusLabel: 'En cours' },
  { id: 3, title: 'Rédaction SEO', date: '1 mai 2026', price: 35, status: 'completed', statusLabel: 'Terminé' },
]

const badgeStyle = (status: string) => {
  if (status === 'completed') return 'background:#dcfce7; color:#166534;'
  if (status === 'in_progress') return 'background:#dbeafe; color:#1e40af;'
  if (status === 'pending') return 'background:#fef9c3; color:#854d0e;'
  return 'background:#fee2e2; color:#991b1b;'
}
</script>