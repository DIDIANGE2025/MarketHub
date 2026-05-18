export interface Order {
  id: number
  buyer_id: number
  service_id: number
  status: 'pending' | 'in_progress' | 'completed' | 'cancelled'
  total_price: number
  created_at: string
}