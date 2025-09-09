// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Define separate input files for public and admin CSS
            input: [
                'resources/css/app.css',    // CSS for Public Site
                'resources/css/admin.css',  // CSS for Admin Panel
                'resources/js/app.js',      // Shared JS (or create admin.js if needed)
            ],
            refresh: true, // Enable hot module replacement/refresh
        }),
    ],
});