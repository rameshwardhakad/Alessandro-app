import { useProjectDetailStore } from 'Store/project-detail'
import { useTaskState } from 'Use/task'

export const useOnTitleUpdate = () => {
  const store = useProjectDetailStore()
  const { list, task } = useTaskState()

  function update(title: string) {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)

    store.project.lists[listIndex].tasks[taskIndex].title = title
  }

  return {
    update,
  }
}
