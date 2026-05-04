<template>
  <main class="max-w-6xl mx-auto px-6 py-10 flex gap-8">
    
    <!-- Sidebar filtres -->
    <aside class="w-64 shrink-0">
      <div class="border rounded-xl p-5 shadow-sm">
        <h2 class="font-bold text-lg mb-4">Filtres</h2>

        <!-- Catégorie -->
        <div class="mb-6">
          <h3 class="font-semibold text-gray-700 mb-2">Catégorie</h3>
          <div v-for="cat in categories" :key="cat" class="flex items-center gap-2 mb-1">
            <input type="checkbox" :id="cat" :value="cat" v-model="selectedCategories" class="accent-indigo-600" />
            <label :for="cat" class="text-gray-600 text-sm cursor-pointer">{{ cat }}</label>
          </div>
        </div>

        <!-- Prix -->
        <div class="mb-6">
          <h3 class="font-semibold text-gray-700 mb-2">Prix maximum</h3>
          <input type="range" min="10" max="200" v-model="maxPrice" class="w-full accent-indigo-600" />
          <p class="text-sm text-gray-500 mt-1">Jusqu'à {{ maxPrice }} €</p>
        </div>

        <!-- Note -->
        <div>
          <h3 class="font-semibold text-gray-700 mb-2">Note minimum</h3>
          <div v-for="n in [4, 3, 2]" :key="n" class="flex items-center gap-2 mb-1">
            <input type="radio" :id="`note${n}`" :value="n" v-model="minRating" class="accent-indigo-600" />
            <label :for="`note${n}`" class="text-yellow-500 text-sm cursor-pointer">
              {{ '★'.repeat(n) }}{{ '☆'.repeat(5 - n) }}
            </label>
          </div>
        </div>
      </div>
    </aside>

    <!-- Grille services -->
    <section class="flex-1">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Catalogue</h1>
        <p class="text-gray-500 text-sm">{{ filteredServices.length }} service(s) trouvé(s)</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <div v-for="service in filteredServices" :key="service.id"
          class="border rounded-xl p-5 shadow-sm hover:shadow-md transition cursor-pointer"
          @click="$router.push(`/services/${service.id}`)">
          <div class="bg-indigo-100 rounded-lg h-28 mb-3 flex items-center justify-center text-3xl">📦</div>
          <h3 class="font-semibold text-gray-800 mb-1">{{ service.title }}</h3>
          <p class="text-gray-500 text-sm mb-3">{{ service.description }}</p>
          <div class="flex justify-between items-center">
            <span class="text-indigo-600 font-bold">{{ service.price }} €</span>
            <span class="text-yellow-500 text-sm">★★★★★</span>
          </div>
        </div>
      </div>

      <p v-if="filteredServices.length === 0" class="text-gray-400 text-center py-20">
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