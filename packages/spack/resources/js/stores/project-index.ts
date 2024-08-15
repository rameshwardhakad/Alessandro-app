import { axios } from 'spack'
import { defineStore } from 'pinia'
import { ref } from 'vue'
// import { useModalsStore } from 'spack'
// import ProjectForm from 'View/projects/Form.vue'

export const useProjectIndexStore = defineStore('project-index', () => {
  const items = ref<ProjectI[]>([]),
    fetching = ref<boolean>(false)

  // function create(): void {
  //   useModalsStore().add(ProjectForm)
  // }

  async function fetch() {
    fetching.value = true

    const { data } = await axios.get<ProjectI[]>('projects/all')

    fetching.value = false
    items.value = data
    console.log(data)
  }

  function archive() {
    console.log('archive')
  }

  function favorite() {
    console.log('favorite')
  }

  function edit() {
    console.log('edit')
  }

  async function sort(id: number, newIndex: number) {
    console.log('sort')

    const { data } = await axios.patch<ProjectI[]>(`projects/${id}/sort`, {
      order: newIndex + 1,
    })

    console.log(data)
  }

  return {
    // create,
    fetching,
    items,
    archive,
    favorite,
    edit,
    sort,

    fetch,
  }
})
