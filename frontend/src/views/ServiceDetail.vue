<template>
  <main style="max-width:1100px; margin:0 auto; padding:2.5rem 1.5rem;">

    <div v-if="service" style="display:flex; gap:2rem; align-items:flex-start;">

      <!-- Colonne gauche -->
      <div style="flex:1;">
        <div style="background:linear-gradient(135deg,#4F46E5,#7C3AED); border-radius:20px; height:220px; display:flex; align-items:center; justify-content:center; font-size:5rem; margin-bottom:1.5rem;">📦</div>

        <div style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem; backdrop-filter:blur(4px); margin-bottom:1rem;">
          <h1 style="font-size:1.8rem; font-weight:700; color:#111; margin-bottom:0.5rem;">{{ service.title }}</h1>
          <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
            <span style="color:#f59e0b; font-size:1rem;">★★★★★</span>
            <span style="color:#888; font-size:0.85rem;">(24 avis)</span>
            <span style="background:#EEF2FF; color:#4F46E5; font-size:0.78rem; font-weight:600; padding:0.2rem 0.6rem; border-radius:20px;">Vendeur vérifié</span>
          </div>
          <p style="color:#555; line-height:1.7; font-size:0.95rem;">{{ service.description }}</p>
        </div>

        <!-- Avis -->
        <div style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem; backdrop-filter:blur(4px);">
          <h2 style="font-size:1.1rem; font-weight:700; color:#111; margin-bottom:1rem;">Avis clients</h2>
          <div style="display:flex; flex-direction:column; gap:0.75rem;">
            <div v-for="review in mockReviews" :key="review.id"
              style="background:#f9fafb; border-radius:12px; padding:1rem;">
              <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">
                <span style="font-weight:600; color:#111; font-size:0.9rem;">{{ review.author }}</span>
                <span style="color:#f59e0b; font-size:0.85rem;">★★★★★</span>
              </div>
              <p style="color:#666; font-size:0.85rem; line-height:1.5;">{{ review.comment }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Carte commande -->
      <aside style="width:280px; min-width:280px; position:sticky; top:6rem;">
        <div style="background:rgba(255,255,255,0.95); border-radius:20px; padding:1.5rem; backdrop-filter:blur(8px);">
          <p style="font-size:2rem; font-weight:800; color:#4F46E5; margin-bottom:0.25rem;">{{ service.price }} €</p>
          <p style="color:#888; font-size:0.82rem; margin-bottom:1.5rem;">Paiement unique · Livraison 3-5 jours</p>

          <button @click="handleOrder"
            style="width:100%; background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.9rem; border-radius:12px; font-size:0.95rem; font-weight:600; cursor:pointer; margin-bottom:0.75rem;">
            Commander maintenant
          </button>

          <button
            style="width:100%; background:white; color:#4F46E5; border:2px solid #4F46E5; padding:0.9rem; border-radius:12px; font-size:0.95rem; font-weight:600; cursor:pointer;">
            Contacter le vendeur
          </button>

          <div style="margin-top:1.25rem; display:flex; flex-direction:column; gap:0.5rem;">
            <p style="font-size:0.82rem; color:#555;">✅ Paiement sécurisé</p>
            <p style="font-size:0.82rem; color:#555;">✅ Remboursement sous 7 jours</p>
            <p style="font-size:0.82rem; color:#555;">✅ Support inclus</p>
          </div>
        </div>
      </aside>

    </div>

    <p v-else style="background:rgba(255,255,255,0.85); border-radius:14px; padding:3rem; text-align:center; color:#666;">
      Service introuvable.
    </p>

  </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getServiceById, createOrder } from '../services/api'
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

const handleOrder = async () => {
  const token = localStorage.getItem('token')
  if (!token) {
    router.push('/login')
    return
  }
  try {
    await createOrder(Number(route.params.id))
    alert('✅ Commande passée avec succès !')
    router.push('/dashboard')
  } catch (e) {
    alert('❌ Erreur lors de la commande')
  }
}
</script>