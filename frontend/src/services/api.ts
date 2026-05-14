import axios from 'axios'

const BASE = 'http://127.0.0.1:8000'

// Instance publique — sans token
const publicApi = axios.create({
  baseURL: BASE,
  headers: { 'Content-Type': 'application/json' }
})

// Instance privée — avec token JWT
const privateApi = axios.create({
  baseURL: BASE,
  headers: { 'Content-Type': 'application/json' }
})

privateApi.interceptors.request.use((config) => {
  const token = localStorage.getItem('access_token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

// Routes publiques
export const getServices = () => publicApi.get('/api/services')
export const getServiceById = (id: number) => publicApi.get(`/api/services/${id}`)

// Routes privées
export const login = (email: string, password: string) =>
  publicApi.post('/api/auth/login', { email, password })
export const register = (email: string, password: string, username: string) =>
  publicApi.post('/api/auth/register', { email, password, username })
export const getMyOrders = () => privateApi.get('/api/orders/my')
export const createOrder = (service_id: number) =>
  privateApi.post('/api/orders', { service_id })