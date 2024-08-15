import { useModalsStore } from 'spack'
import Form from 'View/projects/Form.vue'

export function useProjectCreate() {
  function openModal(): void {
    useModalsStore().add(Form)
  }

  return { openModal }
}
