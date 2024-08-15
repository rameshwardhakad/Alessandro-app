import { ref } from 'vue'
import { axios } from 'spack'

interface Task {
  id: number
  project_id: number
  title: string
  description: string
  due_at: string | null
  human_due_date: string | null
  deleted_at: string | null
}

interface Project {
  id: number
  name: string
  meta: {
    color: string
  }
}

interface ProjectList {
  id: number
  name: string
}

interface Comments {
  id: number
  text: string
  updated_at: string
  user: User
  attachments: any
}

interface Attachments {
  id: number
  name: string
  path: string
  extension: string
  is_image: boolean
  created_at: string
}

const task = ref<Task>({} as Task)
const list = ref<ProjectList>({} as ProjectList)
const project = ref<Project>({} as Project)
const listOptions = ref<SelectOption[]>([])
const userOptions = ref<User[]>([])
const checklists = ref<Checklist[]>([])
const comments = ref<Comments[]>([])
const attachments = ref<Attachments[]>([])
const users = ref<User[]>([])

export const useTaskState = () => {
  const fetching = ref<boolean>(false)

  async function fetch(id: number) {
    fetching.value = true

    const { data } = await axios.get(`tasks/${id}`)

    fetching.value = false
    console.log(data)
    task.value = data.task
    project.value = data.project
    list.value = data.list
    listOptions.value = data.listOptions
    userOptions.value = data.userOptions
    checklists.value = data.checklists.length ? data.checklists : [{ items: [] }]
    comments.value = data.comments
    attachments.value = data.attachments
    users.value = data.users
  }

  return {
    attachments,
    fetch,
    fetching,
    task,
    project,
    list,
    listOptions,
    userOptions,
    checklists,
    comments,
    users,
  }
}
