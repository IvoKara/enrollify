import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { run } from 'vite-plugin-run'
import components from 'unplugin-vue-components/vite'


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
            dirs: ['resources/js/Components'],
        })
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        }
    }
});
