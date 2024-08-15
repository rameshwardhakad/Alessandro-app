import { ref } from 'vue'

const errors = ref<string[]>([])

export const useErrors = () => {
  function error(error: string) {
    errors.value.push(error)
  }

  function clear() {
    errors.value = []
  }

  return {
    error,
    clear,
    errors,
  }
}
