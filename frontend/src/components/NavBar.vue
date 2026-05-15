<template>
  <nav style="background:rgba(15,15,15,0.75); backdrop-filter:blur(10px); padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:100;">
    
    <RouterLink to="/" style="color:white; font-weight:700; font-size:1.2rem; text-decoration:none; letter-spacing:1px;">
      MarketHub
    </RouterLink>

    <div style="display:flex; gap:1rem; align-items:center;">
      <RouterLink to="/catalogue" style="color:rgba(255,255,255,0.85); text-decoration:none; font-size:0.88rem; letter-spacing:1px; text-transform:uppercase; padding:0.4rem 0.75rem; border-radius:8px;"
        @mouseenter="e => e.currentTarget.style.background='rgba(255,255,255,0.15)'"
        @mouseleave="e => e.currentTarget.style.background='transparent'">
        Catalogue
      </RouterLink>

      <RouterLink to="/chat" style="color:rgba(255,255,255,0.85); text-decoration:none; font-size:0.88rem; letter-spacing:1px; text-transform:uppercase; padding:0.4rem 0.75rem; border-radius:8px;"
        @mouseenter="e => e.currentTarget.style.background='rgba(255,255,255,0.15)'"
        @mouseleave="e => e.currentTarget.style.background='transparent'">
        Chat
      </RouterLink>

      <template v-if="isLoggedIn">
        <RouterLink to="/dashboard" style="color:rgba(255,255,255,0.85); text-decoration:none; font-size:0.88rem; letter-spacing:1px; text-transform:uppercase; padding:0.4rem 0.75rem; border-radius:8px;"
          @mouseenter="e => e.currentTarget.style.background='rgba(255,255,255,0.15)'"
          @mouseleave="e => e.currentTarget.style.background='transparent'">
          Mon espace
        </RouterLink>
        <button @click="handleLogout"
          style="background:#ef4444; color:white; border:none; font-size:0.85rem; font-weight:600; letter-spacing:1px; text-transform:uppercase; padding:0.5rem 1.25rem; border-radius:8px; cursor:pointer;">
          Déconnexion
        </button>
      </template>

      <template v-else>
        <RouterLink to="/login" style="background:white; color:#111; text-decoration:none; font-size:0.85rem; font-weight:600; letter-spacing:1px; text-transform:uppercase; padding:0.5rem 1.25rem; border-radius:8px;">
          Connexion
        </RouterLink>
      </template>
    </div>

  </nav>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink, useRouter } from 'vue-router'

const router = useRouter()
const isLoggedIn = ref(false)

const checkAuth = () => {
  isLoggedIn.value = !!localStorage.getItem('token')
}

onMounted(() => {
  checkAuth()
})

router.afterEach(() => {
  checkAuth()
})

const handleLogout = () => {
  localStorage.removeItem('token')
  isLoggedIn.value = false
  router.push('/login')
}
</script>