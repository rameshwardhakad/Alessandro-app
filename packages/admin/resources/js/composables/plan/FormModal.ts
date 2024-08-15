import { useModalsStore } from 'spack'
import Form from 'View/plans/Form.vue'

export function usePlanFormModal() {
  function create(): void {
    useModalsStore().add(Form)
  }

  function edit(id: number) {
    useModalsStore().add(Form, { id })
  }

  return {
    create,
    edit,
  }
}
