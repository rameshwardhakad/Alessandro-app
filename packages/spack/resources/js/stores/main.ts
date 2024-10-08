import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useStore = defineStore('main', () => {
  const isBlankPage = ref<boolean>(false),
    isMobileSidebar = ref<boolean>(false),
    showSidebar = ref<boolean>(true)

  return {
    isBlankPage,
    isMobileSidebar,
    showSidebar,
  }
})
