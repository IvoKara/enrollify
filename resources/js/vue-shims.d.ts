import type { router } from '@inertiajs/vue3'
import type { route } from 'ziggy-js'

declare module 'vue' {
  interface ComponentCustomProperties {
    route: typeof route
    router: typeof router
  }
}
