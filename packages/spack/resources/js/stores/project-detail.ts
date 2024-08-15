import { type Ref, ref } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { axios } from 'spack'
import { useSidebarProjectStore } from './sidebar-project'

interface ProjectDetail {
  fetch: (id: number | string | undefined) => Promise<void>
  fetching: Ref<boolean>
  onColorChange: () => void
  onNameUpdate: (name: string) => void
  project: Ref<Project>
}

interface Task {
  id: number
  temp_id?: number | null
  title: string
  subtasks_count: number
  users_count: number
  completed_subtasks_count: number
  comments_count: number
  due_at: string | null
  human_due_date: string | null
  users: any[]
}

interface List {
  id: number
  temp_id: number | null
  project_id: number
  name: string
  tasks: Task[]
}

interface Project {
  colorOptions: SelectOption[]
  id: number
  lists: List[]
  meta: {
    color: string
  }
  name: string
  users: User[]
}

export const useProjectDetailStore = defineStore('project-detail', (): ProjectDetail => {
  const fetching = ref<boolean>(false),
    project = ref<Partial<Project>>({}) as Ref<Project>

  async function fetch(id: number | string | undefined) {
    fetching.value = true

    const { data } = await axios.get<Project>(`projects/${id}`)

    fetching.value = false
    project.value = data
  }

  function onColorChange() {
    console.log('onColorChange')
    console.log(project.value.meta.color)
    useSidebarProjectStore().updateColor(project.value.id, project.value.meta.color)

    axios.put(`/projects/${project.value.id}`, { color: project.value.meta.color })
  }

  function onNameUpdate(name: string) {
    console.log('onNameUpdate')
    console.log(name)
    project.value.name = name
    useSidebarProjectStore().updateName(project.value.id, name)

    axios.put(`/projects/${project.value.id}`, { name: name })
  }

  return {
    fetch,
    fetching,
    onColorChange,
    onNameUpdate,
    project,
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useProjectDetailStore, import.meta.hot))
}
