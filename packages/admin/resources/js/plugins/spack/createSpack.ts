import type { App } from 'vue'
import { can, cannot } from './util'

/**
 * Installs the Spack plugin, providing global properties and methods.
 */
export const createSpack = {
  install: (app: App) => {
    app.config.globalProperties.can = can
    app.config.globalProperties.cannot = cannot
  },
}
