export interface Media {
  id: number
  url: string
  alt: string
  [key: string]: any
}

export interface Text {
  id: number
  title: string
  content: string
  media: Media | null
  duration: string
}

export interface Video {
  id: number
  title: string
  duration: string
  description: string
  url: string
}

export type LessonContent = {
  id: number
} & {
  type: 'text'
  data: Text
} | {
  type: 'video'
  data: Video
}

export interface Lesson {
  id: number
  title: string
  meta_description: string | null
  overview: string
  duration: string
  contents: any[]
}

export interface Course {
  id: number
  title: string
  slug: string
  description: string | null
  meta_description: null
  duration: string
  is_free: boolean
  price: string
  status: 'published' | 'draft' | 'pending' | 'archived'
  media: Media
  lessons: any[]
  creator: any
}
