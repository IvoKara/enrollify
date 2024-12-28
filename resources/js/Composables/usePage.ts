import type { InertiaProps } from '@/inertia'
import { usePage as usePageInertia } from '@inertiajs/vue3'

export function usePage() {
  return usePageInertia<InertiaProps>()
}
