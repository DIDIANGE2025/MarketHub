<template>
  <nav style="background:rgba(15,15,15,0.75); backdrop-filter:blur(10px); padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:100;">
    
    <RouterLink to="/" style="color:white; font-weight:700; font-size:1.2rem; text-decoration:none; letter-spacing:1px;">
      MarketHub
    </RouterLink>

    <div style="display:flex; gap:1rem; align-items:center;">
      <RouterLink to="/catalogue" style="color:rgba(255,255,255,0.85); text-decoration:none; font-size:0.88rem; letter-spacing:1px; text-transform:uppercase; padding:0.4rem 0.75rem; border-radius:8px; transition:background 0.2s;"
        @mouseenter="e => e.currentTarget.style.background='rgba(255,255,255,0.15)'"
        @mouseleave="e => e.currentTarget.style.background='transparent'">
        Catalogue
      </RouterLink>

      <RouterLink to="/dashboard" style="color:rgba(255,255,255,0.85); text-decoration:none; font-size:0.88rem; letter-spacing:1px; text-transform:uppercase; padding:0.4rem 0.75rem; border-radius:8px; transition:background 0.2s;"
        @mouseenter="e => e.currentTarget.style.background='rgba(255,255,255,0.15)'"
        @mouseleave="e => e.currentTarget.style.background='transparent'">
        Mon espace
      </RouterLink>

      <RouterLink to="/login" style="background:white; color:#111; text-decoration:none; font-size:0.85rem; font-weight:600; letter-spacing:1px; text-transform:uppercase; padding:0.5rem 1.25rem; border-radius:8px; transition:opacity 0.2s;"
        @mouseenter="e => e.currentTarget.style.opacity='0.85'"
        @mouseleave="e => e.currentTarget.style.opacity='1'">
        Connexion
      </RouterLink>
    </div>

  </nav>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>