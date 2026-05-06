import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000',
  headers: { 'Content-Type': 'application/json' }
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('access_token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

export const getServices = () => api.get('/api/services')

export const getServiceById = (id: number) => api.get(`/api/services/${id}`)

export const login = (email: string, password: string) =>
  api.post('/api/auth/login', { email, password })

export const register = (email: string, password: string, username: string) =>
  api.post('/api/auth/register', { email, password, username })

export const getMyOrders = () => api.get('/api/orders/my')

export const createOrder = (service_id: number) =>
  api.post('/api/orders', { service_id })

export default api