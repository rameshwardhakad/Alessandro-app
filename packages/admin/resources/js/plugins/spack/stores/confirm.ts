import { ConfirmModal } from 'thetheme'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { createEventHook, useModalsStore } from 'spack'

export const useConfirmStore = defineStore('confirm', () => {
  const title = ref<string>(''),
    description = ref<string>(''),
    button = ref<string>(''),
    danger = ref<boolean>(false),
    processing = ref<boolean>(false),
    successHook = createEventHook<null>()

  function confirm(payload: any) {
    useModalsStore().add(ConfirmModal)
    title.value = payload.title
    description.value = payload.description
    button.value = payload.button
    danger.value = payload.danger
    processing.value = false
    successHook.on(payload.onProceed)
  }

  function hide() {
    useModalsStore().pop()
  }

  function proceed() {
    processing.value = true
    successHook.trigger(null)
  }

  return {
    button,
    confirm,
    danger,
    description,
    hide,
    proceed,
    processing,
    title,
  }
})
