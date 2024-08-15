import { useProjectDetailStore } from 'Store/project-detail'
import { useTaskState } from 'Use/task'

export const useOnDuedate = () => {
  const store = useProjectDetailStore()
  const { list, task } = useTaskState()

  function update(due_at: string | null, human_due_date: string | null) {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)
    console.log('due_at', due_at)
    console.log('human_due_date', human_due_date)
    store.project.lists[listIndex].tasks[taskIndex].due_at = due_at
    store.project.lists[listIndex].tasks[taskIndex].human_due_date = human_due_date
  }

  return {
    update,
  }
}
