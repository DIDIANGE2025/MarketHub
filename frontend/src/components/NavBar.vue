<template>
  <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center">
    <RouterLink to="/" class="font-bold text-xl">MarketHub</RouterLink>
    <div class="flex gap-4 items-center">
      <RouterLink to="/catalogue" class="hover:underline">Catalogue</RouterLink>
      <RouterLink to="/dashboard" class="hover:underline">Mon espace</RouterLink>
      <RouterLink to="/login" class="bg-white text-indigo-600 px-3 py-1 rounded hover:bg-indigo-50 font-semibold">
        Connexion
      </RouterLink>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>