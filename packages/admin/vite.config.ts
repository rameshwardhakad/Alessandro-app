import { defineConfig } from 'vite'
import { resolve } from 'path'
import hot from './hot'
import vue from '@vitejs/plugin-vue'

const name = 'admin'

const config = {
  root: 'resources',
  server: {
    port: 5202
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
      Plugin: resolve(__dirname, 'resources/js/plugins'),
      spack: resolve(__dirname, 'resources/js/plugins/spack'),
      Store: resolve(__dirname, 'resources/js/stores'),
      thetheme: resolve(__dirname, 'resources/js/plugins/thetheme'),
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
