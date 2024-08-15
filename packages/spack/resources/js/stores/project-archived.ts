import { axios } from 'spack'
import { defineStore } from 'pinia'
import { ref } from 'vue'
// import { useModalsStore } from 'spack'
// import ProjectForm from 'View/projects/Form.vue'
import { useSidebarProjectStore } from './sidebar-project'

export const useProjectArchivedStore = defineStore('project-archived', () => {
  const items = ref<ProjectI[]>([]),
    fetching = ref<boolean>(false)

  // function create(): void {
  //   useModalsStore().add(ProjectForm)
  // }

  async function fetch() {
    fetching.value = true

    const { data } = await axios.get<ProjectI[]>('projects/archived')

    fetching.value = false
    items.value = data
    console.log(data)
  }

  function unarchive(id: number, index: number): void {
    console.log('unarchive')
    axios.patch(`/projects/${id}/unarchive`)

    const item = items.value[index]
    removeItem(index)
    useSidebarProjectStore().addItem(item)
  }

  function removeItem(index: number): void {
    items.value.splice(index, 1)
  }

  return {
    // create,
    fetching,
    items,
    unarchive,
    removeItem,

    fetch,
  }
})
