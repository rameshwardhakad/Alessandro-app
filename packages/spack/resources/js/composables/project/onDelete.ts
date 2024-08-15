import { useProjectDetailStore } from 'Store/project-detail'
import { useTaskState } from 'Use/task'

export const useOnDelete = () => {
  const store = useProjectDetailStore()
  const { list, task } = useTaskState()

  function update() {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)

    store.project.lists[listIndex].tasks.splice(taskIndex, 1)
  }

  return {
    update,
  }
}
