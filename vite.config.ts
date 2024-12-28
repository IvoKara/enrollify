import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { run } from 'vite-plugin-run'
import components from 'unplugin-vue-components/vite'
import autoimports from 'unplugin-auto-import/vite'

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
            condition: (file) => file.includes('/routes/') && file.endsWith('.php')
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
                    names: ['Link', 'Head']
                }
            ]
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

                    from: '@inertiajs/vue3',
                    imports: [
                        'usePage',
                        'useForm',
                    ],
                    type: true
                }
            ]
        })
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        }
    }
});
