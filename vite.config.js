import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: '192.168.18.71',
        },
    },
    build: {
        // Code splitting for better caching
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor-bootstrap': ['bootstrap'],
                },
            },
        },
        // Optimize for production
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
            },
        },
        // Source maps for production debugging
        sourcemap: false,
        // Larger chunk size for better batching
        chunkSizeWarningLimit: 1000,
    },
    // Performance hints
    ssr: false,
});
