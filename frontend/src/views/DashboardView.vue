<template>
  <main class="max-w-5xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold mb-8">Mon espace acheteur</h1>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-6 mb-10">
      <div class="border rounded-xl p-5 text-center shadow-sm">
        <p class="text-3xl font-bold text-indigo-600">3</p>
        <p class="text-gray-500 text-sm mt-1">Commandes totales</p>
      </div>
      <div class="border rounded-xl p-5 text-center shadow-sm">
        <p class="text-3xl font-bold text-green-500">1</p>
        <p class="text-gray-500 text-sm mt-1">En cours</p>
      </div>
      <div class="border rounded-xl p-5 text-center shadow-sm">
        <p class="text-3xl font-bold text-gray-400">2</p>
        <p class="text-gray-500 text-sm mt-1">Terminées</p>
      </div>
    </div>

    <!-- Commandes -->
    <h2 class="text-xl font-bold mb-4">Mes commandes</h2>
    <div class="space-y-4">
      <div v-for="order in mockOrders" :key="order.id"
        class="border rounded-xl p-5 flex justify-between items-center shadow-sm">
        <div>
          <p class="font-semibold text-gray-800">{{ order.title }}</p>
          <p class="text-gray-400 text-sm">{{ order.date }}</p>
        </div>
        <div class="flex items-center gap-4">
          <span class="font-bold text-gray-700">{{ order.price }} €</span>
          <span :class="badgeClass(order.status)" class="px-3 py-1 rounded-full text-xs font-semibold">
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

const badgeClass = (status: string) => ({
  'bg-green-100 text-green-700': status === 'completed',
  'bg-blue-100 text-blue-700': status === 'in_progress',
  'bg-yellow-100 text-yellow-700': status === 'pending',
  'bg-red-100 text-red-700': status === 'cancelled',
})
</script>