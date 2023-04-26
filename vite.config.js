import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vuePlugin from "@vitejs/plugin-vue";
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vuePlugin()
    ],
    manifestDir: 'public/build',
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
            '@components': resolve(__dirname, 'resources/js/Pages'),
        },
    },
    css: {
        postcss: {
            plugins: [
                require('tailwindcss'),
                require('autoprefixer'),
            ],
        },
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: '/resources/js/app.js',
        },
    },
});
