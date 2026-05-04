export interface Service {
  id: number
  seller_id: number
  category_id: number
  title: string
  description: string
  price: number
  status: 'active' | 'inactive'
  created_at: string
}