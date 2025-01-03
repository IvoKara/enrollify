export interface Course {
  id: number
  title: string
  url: string
  description: string | null
  meta_description: null
  duration: string
  is_free: boolean
  price: string
  status: 'published' | 'draft' | 'pending' | 'archived'
  media: any
  lessons: any[]
  creator: any
}
