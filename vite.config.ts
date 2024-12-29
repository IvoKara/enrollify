import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import autoimports from 'unplugin-auto-import/vite'
import components from 'unplugin-vue-components/vite'
import { defineConfig } from 'vite'
import { run } from 'vite-plugin-run'

export default defineConfig({
  plugins: [
    laravel({
      input: 'resources/js/app.ts',
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    run([{
      name: 'ziggy',
      run: ['php', 'artisan', 'ziggy:generate', '--types'],
      condition: file => file.includes('/routes/') && file.endsWith('.php'),
    }]),
    components({
      dts: true,
      dirs: [
        'resources/js/Components',
        'resources/js/Layouts',
      ],
      types: [
        {
          from: '@inertiajs/vue3',
          names: ['Link', 'Head'],
        },
      ],
    }),
    autoimports({
      dts: true,
      dirs: [
        'resources/js/Composables',
        'resources/js/Utils',
      ],
      imports: [
        'vue',
        {
          axios: [
            ['default', 'axios'], // import { default as axios } from 'axios',
          ],
        },
        {

          from: '@inertiajs/vue3',
          imports: [
            'usePoll',
            'useForm',
            'router',
            'useRemember',
            'usePrefetch',
          ],
        },
        {
          from: 'ziggy-js',
          imports: ['route'],
        },
      ],
    }),
  ],
  resolve: {
    alias: {
      '@': '/resources/js',
      'ziggy-js': '/vendor/tightenco/ziggy',
    },
  },
})
