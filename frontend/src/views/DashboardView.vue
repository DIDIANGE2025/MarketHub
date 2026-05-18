x<template>
  <div style="max-width:1000px; margin:0 auto; padding:2rem 1.5rem;">

    <!-- DASHBOARD VENDEUR -->
    <template v-if="isVendeur">
      <h1 style="color:white; font-size:1.8rem; font-weight:700; margin-bottom:0.5rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
        🏪 Espace Vendeur
      </h1>
      <p style="color:rgba(255,255,255,0.7); margin-bottom:2rem;">Gérez vos services et revenus</p>

      <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem;">
        <div style="background:rgba(79,70,229,0.85); border-radius:14px; padding:1.5rem; text-align:center;">
          <p style="font-size:2rem; font-weight:700; color:white;">{{ mesServices.length }}</p>
          <p style="color:rgba(255,255,255,0.85); font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Mes services</p>
        </div>
        <div style="background:rgba(22,163,74,0.85); border-radius:14px; padding:1.5rem; text-align:center;">
          <p style="font-size:2rem; font-weight:700; color:white;">{{ revenusTotal }} €</p>
          <p style="color:rgba(255,255,255,0.85); font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Revenus totaux</p>
        </div>
        <div style="background:rgba(30,30,30,0.75); border-radius:14px; padding:1.5rem; text-align:center;">
          <p style="font-size:2rem; font-weight:700; color:white;">{{ mesServices.filter(s => s.status === 'active').length }}</p>
          <p style="color:rgba(255,255,255,0.85); font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Services actifs</p>
        </div>
      </div>

      <div style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
          <h2 style="font-size:1.1rem; font-weight:700; color:#111;">Mes services</h2>
          <button @click="showAddForm = !showAddForm"
            style="background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.5rem 1rem; border-radius:8px; font-size:0.85rem; font-weight:600; cursor:pointer;">
            + Ajouter un service
          </button>
        </div>

        <div v-if="showAddForm" style="background:#EEF2FF; border-radius:12px; padding:1.25rem; margin-bottom:1rem;">
          <h3 style="font-size:1rem; font-weight:600; color:#4F46E5; margin-bottom:1rem;">Nouveau service</h3>
          <input v-model="newService.title" placeholder="Titre du service"
            style="width:100%; padding:0.65rem 1rem; border:1.5px solid #e5e7eb; border-radius:8px; margin-bottom:0.75rem; box-sizing:border-box; font-size:0.9rem;" />
          <textarea v-model="newService.description" placeholder="Description"
            style="width:100%; padding:0.65rem 1rem; border:1.5px solid #e5e7eb; border-radius:8px; margin-bottom:0.75rem; box-sizing:border-box; font-size:0.9rem; height:80px; resize:none; font-family:inherit;"></textarea>
          <input v-model="newService.price" type="number" placeholder="Prix (€)"
            style="width:100%; padding:0.65rem 1rem; border:1.5px solid #e5e7eb; border-radius:8px; margin-bottom:0.75rem; box-sizing:border-box; font-size:0.9rem;" />
          <div style="display:flex; gap:0.75rem;">
            <button @click="ajouterService"
              style="background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.6rem 1.25rem; border-radius:8px; font-size:0.88rem; font-weight:600; cursor:pointer;">
              Publier
            </button>
            <button @click="showAddForm = false"
              style="background:#f3f4f6; color:#666; border:none; padding:0.6rem 1.25rem; border-radius:8px; font-size:0.88rem; cursor:pointer;">
              Annuler
            </button>
          </div>
        </div>

        <div v-if="mesServices.length === 0" style="text-align:center; color:#888; padding:2rem;">
          Vous n'avez pas encore de services.
        </div>
        <div v-for="service in mesServices" :key="service.id"
          style="background:#f9fafb; border-radius:12px; padding:1rem; margin-bottom:0.75rem;">
          <div v-if="editingId !== service.id">
            <div style="display:flex; justify-content:space-between; align-items:center;">
              <div>
                <p style="font-weight:600; color:#111;">{{ service.title }}</p>
                <p style="color:#888; font-size:0.82rem; margin-top:0.25rem;">{{ service.price }} € — {{ service.status }}</p>
              </div>
              <div style="display:flex; gap:0.5rem;">
                <button @click="startEdit(service)"
                  style="background:#EEF2FF; color:#4F46E5; border:none; padding:0.35rem 0.75rem; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
                  Modifier
                </button>
                <button @click="supprimerService(service.id)"
                  style="background:#fee2e2; color:#991b1b; border:none; padding:0.35rem 0.75rem; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
                  Supprimer
                </button>
              </div>
            </div>
          </div>

          <div v-else>
            <input v-model="editService.title" placeholder="Titre"
              style="width:100%; padding:0.5rem; border:1.5px solid #4F46E5; border-radius:8px; margin-bottom:0.5rem; box-sizing:border-box; font-size:0.9rem;" />
            <input v-model="editService.price" type="number" placeholder="Prix"
              style="width:100%; padding:0.5rem; border:1.5px solid #4F46E5; border-radius:8px; margin-bottom:0.5rem; box-sizing:border-box; font-size:0.9rem;" />
            <div style="display:flex; gap:0.5rem;">
              <button @click="sauvegarderService(service.id)"
                style="background:linear-gradient(135deg,#4F46E5,#7C3AED); color:white; border:none; padding:0.4rem 0.9rem; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
                Sauvegarder
              </button>
              <button @click="editingId = null"
                style="background:#f3f4f6; color:#666; border:none; padding:0.4rem 0.9rem; border-radius:8px; font-size:0.82rem; cursor:pointer;">
                Annuler
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>

    <!-- DASHBOARD ACHETEUR -->
    <template v-else>
      <h1 style="color:white; font-size:1.8rem; font-weight:700; margin-bottom:0.5rem; text-shadow:0 2px 10px rgba(0,0,0,0.5);">
        Mon espace acheteur
      </h1>
      <p style="color:rgba(255,255,255,0.7); margin-bottom:2rem;">Gérez vos commandes</p>

      <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem;">
        <div style="background:rgba(79,70,229,0.85); border-radius:14px; padding:1.5rem; text-align:center;">
          <p style="font-size:2rem; font-weight:700; color:white;">{{ orders.length }}</p>
          <p style="color:rgba(255,255,255,0.85); font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Commandes totales</p>
        </div>
        <div style="background:rgba(22,163,74,0.85); border-radius:14px; padding:1.5rem; text-align:center;">
          <p style="font-size:2rem; font-weight:700; color:white;">{{ orders.filter(o => o.status === 'pending').length }}</p>
          <p style="color:rgba(255,255,255,0.85); font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">En cours</p>
        </div>
        <div style="background:rgba(30,30,30,0.75); border-radius:14px; padding:1.5rem; text-align:center;">
          <p style="font-size:2rem; font-weight:700; color:white;">{{ orders.filter(o => o.status === 'completed').length }}</p>
          <p style="color:rgba(255,255,255,0.85); font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; margin-top:0.3rem;">Terminées</p>
        </div>
      </div>

      <div style="background:rgba(255,255,255,0.93); border-radius:16px; padding:1.5rem;">
        <h2 style="font-size:1.1rem; font-weight:700; color:#111; margin-bottom:1rem;">Mes commandes</h2>
        <div v-if="orders.length === 0" style="text-align:center; color:#888; padding:2rem;">
          Aucune commande pour le moment.
        </div>
        <div v-for="order in orders" :key="order.id"
          style="background:#f9fafb; border-radius:12px; padding:1rem; margin-bottom:0.75rem; display:flex; justify-content:space-between; align-items:center;">
          <div>
            <p style="font-weight:600; color:#111;">{{ order.service.title }}</p>
            <p style="color:#888; font-size:0.82rem; margin-top:0.25rem;">{{ order.createdAt }}</p>
          </div>
          <div style="display:flex; align-items:center; gap:0.75rem;">
            <span style="font-weight:700; color:#111;">{{ order.total }} €</span>
            <span :style="order.status === 'completed' ? 'background:#dcfce7; color:#166534;' : 'background:#dbeafe; color:#1e40af;'"
              style="padding:0.3rem 0.75rem; border-radius:20px; font-size:0.78rem; font-weight:600;">
              {{ order.status === 'completed' ? 'Terminé' : 'En cours' }}
            </span>
          </div>
        </div>
      </div>
    </template>

  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const BASE = 'http://127.0.0.1:8000'
const orders = ref<any[]>([])
const mesServices = ref<any[]>([])
const isVendeur = ref(false)
const showAddForm = ref(false)
const editingId = ref<number | null>(null)
const newService = ref({ title: '', description: '', price: '' })
const editService = ref({ title: '', price: '' })

const revenusTotal = computed(() =>
  mesServices.value.reduce((sum, s) => sum + Number(s.price), 0)
)

const getHeaders = () => ({
  Authorization: `Bearer ${localStorage.getItem('token')}`
})

onMounted(async () => {
  const token = localStorage.getItem('token')
  if (token) {
    try {
      const payload = JSON.parse(atob(token.split('.')[1]))
      isVendeur.value = payload.email?.includes('vendeur') || false
    } catch {}
  }

  if (isVendeur.value) {
    const res = await axios.get(`${BASE}/api/services`, { headers: getHeaders() })
    mesServices.value = res.data
  } else {
    const res = await axios.get(`${BASE}/api/orders/my`, { headers: getHeaders() })
    orders.value = res.data
  }
})

const ajouterService = async () => {
  await axios.post(`${BASE}/api/services`, newService.value, { headers: getHeaders() })
  const res = await axios.get(`${BASE}/api/services`, { headers: getHeaders() })
  mesServices.value = res.data
  newService.value = { title: '', description: '', price: '' }
  showAddForm.value = false
}

const startEdit = (service: any) => {
  editingId.value = service.id
  editService.value = { title: service.title, price: service.price }
}

const sauvegarderService = async (id: number) => {
  await axios.put(`${BASE}/api/services/${id}`, editService.value, { headers: getHeaders() })
  const s = mesServices.value.find((s: any) => s.id === id)
  if (s) { s.title = editService.value.title; s.price = editService.value.price }
  editingId.value = null
}

const supprimerService = async (id: number) => {
  if (!confirm('Supprimer ce service ?')) return
  await axios.delete(`${BASE}/api/services/${id}`, { headers: getHeaders() })
  mesServices.value = mesServices.value.filter((s: any) => s.id !== id)
}
</script>