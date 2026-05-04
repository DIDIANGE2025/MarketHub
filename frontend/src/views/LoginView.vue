<template>
  <main class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-md p-8 w-full max-w-md">
      <h1 class="text-2xl font-bold text-center mb-2">Connexion</h1>
      <p class="text-gray-500 text-center mb-6">Accédez à votre espace MarketHub</p>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input v-model="email" type="email" placeholder="vous@exemple.com"
          class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
      </div>

      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
        <input v-model="password" type="password" placeholder="••••••••"
          class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
      </div>

      <p v-if="error" class="text-red-500 text-sm mb-4 text-center">{{ error }}</p>

      <button @click="handleLogin"
        class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
        Se connecter
      </button>

      <p class="text-center text-sm text-gray-500 mt-4">
        Pas encore de compte ?
        <RouterLink to="/register" class="text-indigo-600 hover:underline">S'inscrire</RouterLink>
      </p>
    </div>
  </main>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { RouterLink } from 'vue-router'
import { login } from '../services/api'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

const handleLogin = async () => {
  try {
    const res = await login(email.value, password.value)
    localStorage.setItem('access_token', res.data.token)
    localStorage.setItem('refresh_token', res.data.refresh_token)
    router.push('/')
  } catch {
    error.value = 'Email ou mot de passe incorrect.'
  }
}
</script>