import axios from 'axios'

const VITE_USE_MOCK = import.meta.env.VITE_USE_MOCK === 'true'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000',
  headers: { 'Content-Type': 'application/json' }
})

// Intercepteur requête — ajoute le JWT
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('access_token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

// Intercepteur réponse — refresh automatique si 401
api.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (error.response?.status === 401) {
      const refresh = localStorage.getItem('refresh_token')
      if (refresh) {
        try {
          const { data } = await axios.post('/api/auth/refresh', { refresh_token: refresh })
          localStorage.setItem('access_token', data.token)
          error.config.headers.Authorization = `Bearer ${data.token}`
          return api.request(error.config)
        } catch {
          localStorage.clear()
          window.location.href = '/login'
        }
      }
    }
    return Promise.reject(error)
  }
)

// Mocks
const mockServices = [
  { id: 1, seller_id: 1, category_id: 1, title: 'Cours JavaScript débutant', description: 'Apprenez JS from scratch', price: 29, status: 'active', created_at: '2026-05-04' },
  { id: 2, seller_id: 2, category_id: 2, title: 'Design UI/UX Figma', description: 'Maîtrisez Figma en 5h', price: 49, status: 'active', created_at: '2026-05-04' },
]

export const getServices = () =>
  VITE_USE_MOCK
    ? Promise.resolve({ data: mockServices })
    : api.get('/api/levels')

export const getServiceById = (id: number) =>
  VITE_USE_MOCK
    ? Promise.resolve({ data: mockServices.find(s => s.id === id) })
    : api.get(`/api/levels/${id}`)

export const login = (email: string, password: string) =>
  VITE_USE_MOCK
    ? Promise.resolve({ data: { token: 'mock-token', refresh_token: 'mock-refresh' } })
    : api.post('/api/auth/login', { email, password })

export default api