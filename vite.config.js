import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ command }) => ({
    // En producción usa rutas relativas para que funcionen en cualquier subdirectorio
    base: command === 'build' ? './' : '/',
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        // Genera el manifest con rutas relativas
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            output: {
                // Asegura nombres de archivo consistentes
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]'
            }
        }
    }
}));
