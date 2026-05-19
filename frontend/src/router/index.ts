import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: HomeView },
    { path: '/catalogue', component: () => import('@/views/CatalogueView.vue') },
    { path: '/login', component: () => import('@/views/LoginView.vue') },
    { path: '/register', component: () => import('@/views/RegisterView.vue') },
    { path: '/services', component: () => import('@/views/CatalogueView.vue') },
    { path: '/services/:id', component: () => import('@/views/ServiceDetail.vue') },
    { path: '/dashboard', component: () => import('@/views/DashboardView.vue') },
    { path: '/chat', component: () => import('@/views/ChatView.vue') },
    { path: '/agent', component: () => import('@/views/AgentView.vue') },
    { path: '/admin', component: () => import('@/views/AdminView.vue') },
    { path: '/swagger', component: () => import('@/views/SwaggerView.vue') },
  ]
})

export default router