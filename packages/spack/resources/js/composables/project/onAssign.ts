import { useProjectDetailStore } from 'Store/project-detail'
import { useTaskState } from 'Use/task'

export const useOnAssign = () => {
  const store = useProjectDetailStore()
  const { list, task } = useTaskState()

  function assign(user: any) {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)

    store.project.lists[listIndex].tasks[taskIndex].users.push(user)
    store.project.lists[listIndex].tasks[taskIndex].users_count += 1
  }

  function unassign(user: any) {
    const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
    const taskIndex = store.project.lists[listIndex].tasks.findIndex((x) => x.id === task.value.id)
    const userIndex = store.project.lists[listIndex].tasks[taskIndex].users.findIndex((x) => x.id === user.id)

    store.project.lists[listIndex].tasks[taskIndex].users.splice(userIndex, 1)
    store.project.lists[listIndex].tasks[taskIndex].users_count -= 1
  }

  return {
    assign,
    unassign,
  }
}
