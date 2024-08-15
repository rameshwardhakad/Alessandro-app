import { defineStore } from 'pinia'

export const useToastStore = defineStore('toast', {
  state: (): { message: string | null; type: string } => ({
    message: null,
    type: 'success',
  }),

  actions: {
    hide() {
      this.message = null
    },

    flash(message: string, type = 'success') {
      this.message = message
      this.type = type

      setTimeout(() => {
        this.hide()
      }, 4000)
    },

    success(message: string) {
      this.flash(message, 'success')
    },

    danger(message: string) {
      this.flash(message, 'danger')
    },
  },
})
