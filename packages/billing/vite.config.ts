import { defineConfig } from 'vite'
import { resolve } from 'path'
import hot from './hot'
import vue from '@vitejs/plugin-vue'

const name = 'billing'

const config = {
  root: 'resources',
  server: {
    port: 5204
  },
  plugins: [
    hot(),
    vue({
      script: {
        defineModel: true
      }
    }),
  ],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources/js'),
      Component: resolve(__dirname, 'resources/js/components'),
      Store: resolve(__dirname, 'resources/js/stores'),
      Use: resolve(__dirname, 'resources/js/composables'),
      View: resolve(__dirname, 'resources/js/views')
    },
  },
  build: {
    chunkSizeWarningLimit: 800,
    manifest: true,
    emptyOutDir: true,
    outDir: '../../../public/vendor/' + name,
    rollupOptions: {
      input: resolve(__dirname, 'resources/js/main.ts'),
    },
  },
}

const configProduction = {
  esbuild: {
    drop: ['console', 'debugger'],
  },
}

export default defineConfig(({ command }) => {
  if (command === 'build') {
    return Object.assign(config, configProduction)
  }

  return config
})
