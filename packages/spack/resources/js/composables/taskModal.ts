import { useModalsStore } from 'spack'

export const useTaskModal = () => {
  function close() {
    useModalsStore().pop()
  }

  return {
    close,
  }
}
