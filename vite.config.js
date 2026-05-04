import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // --- CSS ---
                'resources/css/frontend.css',
                'resources/css/staff.css',
                // --- JS ---
                'resources/js/frontend/app.js',
                'resources/js/staff/index.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
