import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [vue()],
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        rollupOptions: {
            input: path.resolve(__dirname, 'src/resources/js/main.js'),
            output: {
                entryFileNames: 'assets/index.js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    const fileName = assetInfo.names?.[0] || '';
                    if (fileName.endsWith('.css')) {
                        return 'assets/styles.css';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'src/resources/js'),
        },
    },
    server: {
        host: 'localhost',
        port: 3000,
        strictPort: true,
    },
});
