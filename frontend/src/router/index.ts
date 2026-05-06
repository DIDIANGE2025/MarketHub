import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/catalogue', component: () => import('@/views/CatalogueView.vue') },
    { path: '/', component: HomeView },
    { path: '/login', component: () => import('@/views/LoginView.vue') },
    { path: '/register', component: () => import('@/views/RegisterView.vue') },
    { path: '/services', component: () => import('@/views/CatalogueView.vue') },
    { path: '/services/:id', component: () => import('@/views/ServiceDetail.vue') },
    { path: '/dashboard', component: () => import('@/views/DashboardView.vue') },
  ]
})

export default router