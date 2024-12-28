import type { route } from 'ziggy-js'

declare module 'vue' {
  interface ComponentCustomProperties {
    route: typeof route
  }
}
