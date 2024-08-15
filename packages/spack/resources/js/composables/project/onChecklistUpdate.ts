import { useProjectDetailStore } from 'Store/project-detail'
import { useTaskState } from 'Use/task'

export const useOnChecklistUpdate = () => {
  const store = useProjectDetailStore()
  const { checklists, list, task } = useTaskState()

  function onAdd() {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)

    store.project.lists[listIndex].tasks[taskIndex].subtasks_count += 1
  }

  function onDelete() {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)

    store.project.lists[listIndex].tasks[taskIndex].subtasks_count -= 1
    store.project.lists[listIndex].tasks[taskIndex].completed_subtasks_count = calculateCompletedSubtasksCount()
  }

  function onToggle(state: string | null) {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)

    if (state) {
      store.project.lists[listIndex].tasks[taskIndex].completed_subtasks_count -= 1
    } else {
      store.project.lists[listIndex].tasks[taskIndex].completed_subtasks_count += 1
    }
  }

  function calculateCompletedSubtasksCount() {
    let completedSubtasksCount = 0

    checklists.value[0].items.forEach((item: any) => {
      if (item.completed_at) {
        completedSubtasksCount += 1
      }
    })

    return completedSubtasksCount
  }

  return {
    onAdd,
    onDelete,
    onToggle,
  }
}
