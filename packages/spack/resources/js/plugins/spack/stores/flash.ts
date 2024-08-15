import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useFlashStore = defineStore('flash', () => {
  const message = ref<string>(''),
    type = ref<string>('success')

    function flash(flashMessage: string, flashType: string = 'success') {
      message.value = flashMessage
      type.value = flashType

      setTimeout(() => {
        hide()
      }, 4000)
    }

    function hide() {
      message.value = ''
    }

    function success(message: string) {
      flash(message, 'success')
    }

    function danger(message: string) {
      flash(message, 'danger')
    }

    return {
      danger,
      flash,
      hide,
      message,
      success,
      type,
    }
})
