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
  url_id: string
}

export type LessonContent = {
  id: number
  type: 'text'
  data: Text
  lesson: Lesson
  next_id: number
  prev_id: number
} | {
  id: number
  type: 'video'
  data: Video
  lesson: Lesson
  next_id: number
  prev_id: number
}

export interface Lesson {
  id: number
  title: string
  meta_description: string | null
  overview: string
  duration: string
  contents: LessonContent[]
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
  lessons: Lesson[]
  creator: User
}

export interface User {
  id: number
  name: string
  email: string
  email_verified_at: Date
  created_at: Date
  updated_at: Date
  profile_photo_path: string | null
  profile_photo_url: string | null
  enrolled_courses: string[]
}
