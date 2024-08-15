import { useModalsStore } from 'spack'
import Form from 'View/users/Form.vue'

export function useUserFormModal() {
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
