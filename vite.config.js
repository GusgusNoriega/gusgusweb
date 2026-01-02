import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import fs from 'fs';
import path from 'path';

// Plugin personalizado para copiar manifest a ubicación legacy (Laravel < 11.x)
const copyManifestPlugin = () => ({
    name: 'copy-manifest-legacy',
    closeBundle: () => {
        const sourceDir = 'public/build/.vite';
        const sourcePath = path.join(sourceDir, 'manifest.json');
        const destPath = 'public/build/manifest.json';
        
        // Esperar un poco para que el archivo exista
        setTimeout(() => {
            if (fs.existsSync(sourcePath)) {
                fs.copyFileSync(sourcePath, destPath);
                console.log('✓ Manifest copiado a public/build/manifest.json (compatibilidad Laravel)');
            }
        }, 100);
    }
});

export default defineConfig(({ command }) => ({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        // Solo copiar manifest en build de producción
        command === 'build' && copyManifestPlugin(),
    ].filter(Boolean),
    build: {
        // Genera el manifest
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
