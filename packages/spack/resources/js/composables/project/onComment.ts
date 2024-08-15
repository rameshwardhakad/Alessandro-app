import { useProjectDetailStore } from 'Store/project-detail'
import { useTaskState } from 'Use/task'

export const useOnComment = () => {
  const store = useProjectDetailStore()
  const { list, task } = useTaskState()

  function add() {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)

    store.project.lists[listIndex].tasks[taskIndex].comments_count += 1
  }

  function remove() {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)

    store.project.lists[listIndex].tasks[taskIndex].comments_count -= 1
  }

  return {
    add,
    remove,
  }
}
