import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [vue()],
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: path.resolve(__dirname, 'src/resources/js/main.js'),
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