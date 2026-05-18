<template>
  <main>
    <!-- HERO -->
    <section style="min-height:90vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:2rem;">
      <div>
        <p style="color:rgba(255,255,255,0.8); font-size:0.85rem; letter-spacing:4px; text-transform:uppercase; margin-bottom:1.5rem;">Marketplace étudiant</p>
        <h1 style="color:white; font-size:clamp(2.5rem,6vw,4.5rem); font-weight:800; line-height:1.1; margin-bottom:1.5rem; text-shadow:0 2px 20px rgba(0,0,0,0.3);">
          DES SERVICES<br>PAR DES ÉTUDIANTS<br>POUR DES ÉTUDIANTS
        </h1>
        <p style="color:rgba(255,255,255,0.85); font-size:1.1rem; margin-bottom:2.5rem; text-shadow:0 1px 8px rgba(0,0,0,0.3);">
          Trouvez des experts en dev, design, rédaction et plus encore.
        </p>
        <RouterLink to="/catalogue"
          style="display:inline-block; background:white; color:#111; font-weight:700; font-size:0.85rem; letter-spacing:3px; text-transform:uppercase; padding:1rem 2.5rem; border-radius:8px; text-decoration:none; transition:opacity 0.2s;"
          @mouseenter="e => e.currentTarget.style.opacity='0.9'"
          @mouseleave="e => e.currentTarget.style.opacity='1'">
          Parcourir les services
        </RouterLink>
      </div>
    </section>

    <!-- SERVICES POPULAIRES -->
    <section style="max-width:1200px; margin:0 auto; padding:4rem 1.5rem;">
      <h2 style="color:white; font-size:1.6rem; font-weight:700; margin-bottom:2rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
        Services populaires
      </h2>
      <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:1.25rem;">
        <div v-for="service in services" :key="service.id"
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
    </section>
  </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { getServices } from '../services/api'
import type { Service } from '../types/Service'

const services = ref<Service[]>([])

onMounted(async () => {
  const res = await getServices()
  services.value = res.data
})
</script>