import { nextTick, ref } from 'vue'
import { axios, useIndexStore } from 'spack'
import { useTaskState } from './index'
import { useOnTitleUpdate } from 'Use/project/onTitleUpdate'

export const useTaskTitle = () => {
  const isEditing = ref<boolean>(false)
  const heading = ref<HTMLInputElement | null>(null)

  function edit() {
    if (isEditing.value) {
      return
    }

    isEditing.value = true

    nextTick(() => heading.value?.focus())
  }

  async function update(event: Event) {
    const title = (event.target as HTMLElement).textContent as string
    const { task } = useTaskState()

    isEditing.value = false

    if (!title || title === task.value.title) {
      const prevTitle = task.value.title

      task.value.title = title
      setTimeout(() => (task.value.title = prevTitle))

      return
    }

    await axios.patch(`/tasks/${task.value.id}/title`, {
      title,
    })

    const isTasksPage = window.location.href.includes('/tasks')

    if (isTasksPage) {
      useIndexStore('tasks')().fetch({ loading: false })
    } else {
      useOnTitleUpdate().update(title)
    }
  }

  function onEnter(event: KeyboardEvent) {
    event.preventDefault()
    heading.value?.blur()
  }

  return {
    update,
    edit,
    onEnter,
    heading,
    isEditing,
  }
}
