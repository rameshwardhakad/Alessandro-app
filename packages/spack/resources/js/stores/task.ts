import { reactive, ref } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { axios } from 'spack'
import { useTaskList } from 'Use/taskList'
import { useTaskProject } from 'Use/taskProject'

interface Task {
  id: number
  title: string
  description: string | null
}

export const useTaskStore = defineStore('task', () => {
  const fetching = ref<boolean>(false),
    task = reactive<Partial<Task>>({}) as Task

  async function fetch(id: number) {
    fetching.value = true

    const { data } = await axios.get(`tasks/${id}`)

    fetching.value = false
    Object.assign(task, data.task)

    useTaskList().initData({
      list: data.list,
      options: data.listOptions,
    })

    useTaskProject().initData({
      project: data.project,
    })
  }

  function updateTitle(title: string) {
    task.title = title

    // Sync with server
    // Update in project detail
  }

  return {
    updateTitle,
    task,
    fetching,
    fetch,
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useTaskStore, import.meta.hot))
}
