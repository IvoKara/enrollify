import type { DefineComponent } from 'vue'

import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { createApp, h } from 'vue'
import { ZiggyVue } from 'ziggy-js'

import '../css/app.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: (name) => {
    const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component('Link', Link)
      .component('Head', Head)
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
