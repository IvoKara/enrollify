import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { run } from 'vite-plugin-run'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
        }])
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        }
    }
});
