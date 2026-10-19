import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        origin: process.env.NGROK_URL || 'http://localhost:5173',
        hmr: {
            host: process.env.NGROK_HOST || '127.0.0.1',
            protocol: process.env.NGROK_HMR_PROTOCOL || 'ws',
            port: process.env.NGROK_HMR_PORT ? parseInt(process.env.NGROK_HMR_PORT) : undefined,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
