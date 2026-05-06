<template>
  <main style="display:flex; gap:1.5rem; max-width:1200px; margin:0 auto; padding:2rem 1.5rem;">

    <!-- SIDEBAR FILTRES -->
    <aside style="width:220px; min-width:220px; background:rgba(255,255,255,0.92); border-radius:16px; padding:1.5rem; backdrop-filter:blur(6px); height:fit-content;">
      <h2 style="font-size:1rem; font-weight:700; color:#111; margin-bottom:1.25rem; letter-spacing:-0.3px;">Filtres</h2>

      <h3 style="font-size:0.8rem; font-weight:600; color:#444; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.75rem;">Catégorie</h3>
      <div v-for="cat in categories" :key="cat" style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
        <input type="checkbox" :value="cat" v-model="selectedCategories" style="accent-color:#4F46E5;" />
        <label style="font-size:0.88rem; color:#333; cursor:pointer;">{{ cat }}</label>
      </div>

      <hr style="border:none; border-top:1px solid #eee; margin:1.25rem 0;" />

      <h3 style="font-size:0.8rem; font-weight:600; color:#444; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.75rem;">Prix maximum</h3>
      <input type="range" min="10" max="200" v-model="maxPrice" style="width:100%; accent-color:#4F46E5;" />
      <p style="font-size:0.82rem; color:#666; margin-top:0.4rem;">Jusqu'à {{ maxPrice }} €</p>

      <hr style="border:none; border-top:1px solid #eee; margin:1.25rem 0;" />

      <h3 style="font-size:0.8rem; font-weight:600; color:#444; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.75rem;">Note minimum</h3>
      <div v-for="n in [4, 3, 2]" :key="n" style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
        <input type="radio" :id="`note${n}`" :value="n" v-model="minRating" style="accent-color:#4F46E5;" />
        <label :for="`note${n}`" style="color:#f59e0b; font-size:0.85rem; cursor:pointer;">
          {{ '★'.repeat(n) }}{{ '☆'.repeat(5 - n) }}
        </label>
      </div>
    </aside>

    <!-- GRILLE SERVICES -->
    <section style="flex:1;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <h1 style="font-size:1.6rem; font-weight:700; color:white; text-shadow:0 2px 10px rgba(0,0,0,0.5);">Catalogue</h1>
        <span style="background:rgba(255,255,255,0.9); color:#4F46E5; font-size:0.82rem; font-weight:600; padding:0.4rem 1rem; border-radius:20px;">
          {{ filteredServices.length }} service(s) trouvé(s)
        </span>
      </div>

      <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px,1fr)); gap:1rem;">
        <div v-for="service in filteredServices" :key="service.id"
          @click="$router.push(`/services/${service.id}`)"
          style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.25rem; cursor:pointer; transition:transform 0.2s; backdrop-filter:blur(4px);"
          @mouseenter="e => e.currentTarget.style.transform='translateY(-4px)'"
          @mouseleave="e => e.currentTarget.style.transform='translateY(0)'">
          <div style="background:linear-gradient(135deg,#4F46E5,#7C3AED); border-radius:10px; height:80px; margin-bottom:1rem; display:flex; align-items:center; justify-content:center; font-size:2rem;">📦</div>
          <h3 style="font-weight:600; color:#111; font-size:0.95rem; margin-bottom:0.4rem;">{{ service.title }}</h3>
          <p style="color:#666; font-size:0.82rem; margin-bottom:1rem; line-height:1.5;">{{ service.description }}</p>
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="background:#EEF2FF; color:#4F46E5; font-weight:700; padding:0.3rem 0.75rem; border-radius:20px; font-size:0.9rem;">{{ service.price }} €</span>
            <span style="color:#f59e0b; font-size:0.85rem;">★★★★★</span>
          </div>
        </div>
      </div>

      <p v-if="filteredServices.length === 0"
        style="background:rgba(255,255,255,0.85); border-radius:14px; padding:3rem; text-align:center; color:#666; margin-top:1rem; backdrop-filter:blur(4px);">
        Aucun service ne correspond à vos filtres.
      </p>
    </section>
  </main>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { getServices } from '../services/api'
import type { Service } from '../types/Service'

const services = ref<Service[]>([])
const categories = ['Développement', 'Design', 'Rédaction', 'Marketing']
const selectedCategories = ref<string[]>([])
const maxPrice = ref(200)
const minRating = ref(1)

onMounted(async () => {
  const res = await getServices()
  services.value = res.data
})

const filteredServices = computed(() =>
  services.value.filter(s => s.price <= maxPrice.value)
)
</script>