import { useModalsStore } from 'spack'
import { axios } from 'spack'
import { useProjectIndexStore } from 'Store/project-index'
import { useSidebarProjectStore } from 'Store/sidebar-project'
import Form from 'View/projects/Form.vue'

export function useProject() {
  function create(): void {
    useModalsStore().add(Form)
  }

  function archive(id: number, index: number): void {
    axios.patch(`/projects/${id}/archive`)

    removeItem(index)
    removeSidebarItem(index)
  }

  function removeItem(index: number): void {
    const store = useProjectIndexStore()

    store.items.splice(index, 1)
  }

  function removeSidebarItem(index: number): void {
    const store = useSidebarProjectStore()

    store.items.splice(index, 1)
  }

  return { create, archive, removeItem, removeSidebarItem }
}
