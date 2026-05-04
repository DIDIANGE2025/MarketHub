<template>
  <main class="max-w-5xl mx-auto px-6 py-10">
    <div v-if="service" class="flex gap-10">
      
      <!-- Colonne gauche -->
      <div class="flex-1">
        <div class="bg-indigo-100 rounded-2xl h-56 flex items-center justify-center text-6xl mb-6">📦</div>
        <h1 class="text-3xl font-bold mb-2">{{ service.title }}</h1>
        <div class="flex items-center gap-3 mb-4">
          <span class="text-yellow-500">★★★★★</span>
          <span class="text-gray-400 text-sm">(24 avis)</span>
        </div>
        <p class="text-gray-600 leading-relaxed mb-8">{{ service.description }}</p>

        <!-- Avis -->
        <h2 class="text-xl font-bold mb-4">Avis clients</h2>
        <div class="space-y-4">
          <div v-for="review in mockReviews" :key="review.id"
            class="border rounded-xl p-4">
            <div class="flex justify-between mb-1">
              <span class="font-semibold text-gray-800">{{ review.author }}</span>
              <span class="text-yellow-500">★★★★★</span>
            </div>
            <p class="text-gray-500 text-sm">{{ review.comment }}</p>
          </div>
        </div>
      </div>

      <!-- Carte commande sticky -->
      <aside class="w-72 shrink-0">
        <div class="border rounded-2xl p-6 shadow-md sticky top-6">
          <p class="text-3xl font-bold text-indigo-600 mb-1">{{ service.price }} €</p>
          <p class="text-gray-500 text-sm mb-6">Paiement unique · Livraison 3-5 jours</p>

          <button @click="handleOrder"
            class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition mb-3">
            Commander maintenant
          </button>

          <button
            class="w-full border border-indigo-600 text-indigo-600 py-3 rounded-xl font-semibold hover:bg-indigo-50 transition">
            Contacter le vendeur
          </button>

          <div class="mt-6 space-y-2 text-sm text-gray-500">
            <p>✅ Paiement sécurisé</p>
            <p>✅ Remboursement sous 7 jours</p>
            <p>✅ Support inclus</p>
          </div>
        </div>
      </aside>
    </div>

    <p v-else class="text-gray-400 text-center py-20">Service introuvable.</p>
  </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getServiceById } from '../services/api'
import type { Service } from '../types/Service'

const route = useRoute()
const router = useRouter()
const service = ref<Service | null>(null)

const mockReviews = [
  { id: 1, author: 'Marie L.', comment: 'Excellent service, très professionnel !' },
  { id: 2, author: 'Thomas B.', comment: 'Livraison rapide, je recommande.' },
]

onMounted(async () => {
  const res = await getServiceById(Number(route.params.id))
  service.value = res.data
})

const handleOrder = () => {
  const token = localStorage.getItem('access_token')
  if (!token) {
    router.push('/login')
  } else {
    alert('Commande passée avec succès !')
  }
}
</script>
