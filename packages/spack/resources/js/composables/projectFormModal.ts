import { useModalsStore } from 'spack'
import Form from 'View/projects/Form.vue'

export function useProjectFormModal() {
  function create(): void {
    useModalsStore().add(Form)
  }

  function edit(id: number) {
    useModalsStore().add(Form, { id })
  }

  function close(): void {
    useModalsStore().pop()
  }

  return {
    create,
    edit,
    close,
  }
}
