import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  server: {
    // Configuration pour Docker
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    
    // Configuration HMR (Hot Module Replacement)
    hmr: {
      host: 'localhost',
      port: 5174,
    },
    
    // Pour que le serveur soit accessible depuis l'hôte
    watch: {
      usePolling: true,
    },
    
    // Configuration proxy pour l'API (optionnel)
    proxy: {
      '/api': {
        target: 'http://api:8000',
        changeOrigin: true,
        secure: false,
      }
    }
  },
  preview: {
    host: '0.0.0.0',
    port: 3000,
  }
})
