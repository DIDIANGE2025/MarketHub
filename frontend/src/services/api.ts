import axios from 'axios'
import { useAuthStore } from '../stores/authStore'

const BASE = 'http://127.0.0.1:8000'

const publicApi = axios.create({
  baseURL: BASE,
  headers: { 'Content-Type': 'application/json' }
})

const privateApi = axios.create({
  baseURL: BASE,
  headers: { 'Content-Type': 'application/json' }
})

privateApi.interceptors.request.use((config) => {
  const token = localStorage.getItem('token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

export const getServices = () => publicApi.get('/api/services')
export const getServiceById = (id: number) => publicApi.get(`/api/services/${id}`)
export const login = (email: string, password: string) =>
  publicApi.post('/api/auth/login', { email, password })
export const register = (email: string, password: string, username: string) =>
  publicApi.post('/api/auth/register', { email, password, username })
export const getMyOrders = () => privateApi.get('/api/orders/my')
export const createOrder = (service_id: number) =>
  privateApi.post('/api/orders', { service_id })