
<template>
  <div style="min-height:85vh; display:flex; align-items:center; justify-content:center; padding:2rem;">

    <div style="background:rgba(255,255,255,0.95); border-radius:20px; padding:2.5rem 2rem; width:100%; max-width:420px; backdrop-filter:blur(8px);">

      <!-- Header -->
      <div style="text-align:center; margin-bottom:2rem;">
        <div style="background:linear-gradient(135deg,#4F46E5,#7C3AED); width:56px; height:56px; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:1.5rem;">🎓</div>
        <h1 style="font-size:1.5rem; font-weight:700; color:#111; margin-bottom:0.4rem;">Créer un compte</h1>
        <p style="color:#888; font-size:0.88rem;">Rejoins la communauté MarketHub</p>
      </div>

      <!-- Erreur -->
      <div v-if="error" style="background:#fee2e2; color:#991b1b; padding:0.75rem 1rem; border-radius:10px; font-size:0.85rem; margin-bottom:1.25rem; text-align:center;">
        {{ error }}
      </div>

      <!-- Succès -->
      <div v-if="success" style="background:#dcfce7; color:#166534; padding:0.75rem 1rem; border-radius:10px; font-size:0.85rem; margin-bottom:1.25rem; text-align:center;">
        Compte créé ! Redirection...
      </div>

      <!-- Champs -->
      <div style="margin-bottom:1rem;">
        <label style="display:block; font-size:0.82rem; font-weight:600; color:#444; margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.5px;">Nom d'utilisateur</label>
        <input v-model="username" type="text" placeholder="TonPseudo"
          style="width:100%; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.95rem; color:#111; outline:none; box-sizing:border-box;"
          @focus="e => e.target.style.borderColor='#4F46E5'"
          @blur="e => e.target.style.borderColor='#e5e7eb'" />
      </div>

      <div style="margin-bottom:1rem;">
        <label style="display:block; font-size:0.82rem; font-weight:600; color:#444; margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.5px;">Email</label>
        <input v-model="email" type="email" placeholder="vous@exemple.com"
          style="width:100%; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.95rem; color:#111; outline:none; box-sizing:border-box;"
          @focus="e => e.target.style.borderColor='#4F46E5'"
          @blur="e => e.target.style.borderColor='#e5e7eb'" />
      </div>

      <div style="margin-bottom:1.5rem;">
        <label style="display:block; font-size:0.82rem; font-weight:600; color:#444; margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.5px;">Mot de passe</label>
        <input v-model="password" type="password" placeholder="••••••••"
          style="width:100%; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:10px; font-size:0.95rem; color:#111; outline:none; box-sizing:border-box;"
          @focus="e => e.target.style.borderColor='#4F46E5'"
          @blur="e => e.target.style.borderColor='#e5e7eb'" />
      </div>

      <!-- Bouton -->
      <button @click="handleRegister"
        style="width:100%; background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.85rem; border-radius:10px; font-size:0.95rem; font-weight:600; cursor:pointer; letter-spacing:0.5px;">
        Créer mon compte
      </button>

      <!-- Lien login -->
      <p style="text-align:center; margin-top:1.25rem; font-size:0.85rem; color:#888;">
        Déjà un compte ?
        <RouterLink to="/login" style="color:#4F46E5; font-weight:600; text-decoration:none;">Se connecter</RouterLink>
      </p>

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { register } from '../services/api'

const username = ref('')
const email = ref('')
const password = ref('')
const error = ref('')
const success = ref(false)
const router = useRouter()

const handleRegister = async () => {
  error.value = ''
  if (!username.value || !email.value || !password.value) {
    error.value = 'Tous les champs sont obligatoires'
    return
  }
  try {
    await register(email.value, password.value, username.value)
    success.value = true
    setTimeout(() => router.push('/login'), 1500)
  } catch (e) {
    error.value = 'Erreur lors de l\'inscription'
  }
}
</script>