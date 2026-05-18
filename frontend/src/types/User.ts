export interface User {
  id: number
  username: string
  email: string
  role: 'buyer' | 'seller' | 'admin'
  created_at: string
}