<template>
  <main>
    <!-- Hero -->
    <section class="bg-indigo-600 text-white py-20 px-6 text-center">
      <h1 class="text-4xl font-bold mb-4">La marketplace des services freelance</h1>
      <p class="text-lg mb-8 text-indigo-100">Trouvez des experts en dev, design, rédaction et plus encore.</p>
      <RouterLink to="/catalogue" class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg hover:bg-indigo-50">
        Parcourir les services
      </RouterLink>
    </section>

    <!-- Services récents -->
    <section class="max-w-6xl mx-auto px-6 py-12">
      <h2 class="text-2xl font-bold mb-6">Services populaires</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div v-for="service in services" :key="service.id"
          class="border rounded-xl p-5 shadow-sm hover:shadow-md transition cursor-pointer"
          @click="$router.push(`/services/${service.id}`)">
          <div class="bg-indigo-100 rounded-lg h-32 mb-4 flex items-center justify-center text-indigo-400 text-3xl">📦</div>
          <h3 class="font-semibold text-gray-800 mb-1">{{ service.title }}</h3>
          <p class="text-gray-500 text-sm mb-3">{{ service.description }}</p>
          <div class="flex justify-between items-center">
            <span class="text-indigo-600 font-bold">{{ service.price }} €</span>
            <span class="text-yellow-500 text-sm">★★★★★</span>
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