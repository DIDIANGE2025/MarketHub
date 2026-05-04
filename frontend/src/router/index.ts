import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: () => import('../views/HomeView.vue') },
    { path: '/catalogue', component: () => import('../views/CatalogueView.vue') },
    { path: '/services/:id', component: () => import('../views/ServiceDetail.vue') },
    { path: '/dashboard', component: () => import('../views/DashboardView.vue') },
    { path: '/login', component: () => import('../views/LoginView.vue') },
    { path: '/register', component: () => import('../views/RegisterView.vue') },
  ]
})

export default router