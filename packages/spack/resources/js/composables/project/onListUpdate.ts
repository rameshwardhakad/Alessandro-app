import { useProjectDetailStore } from 'Store/project-detail'

export const useOnListUpdate = () => {
  const store = useProjectDetailStore()

  function move(prevListId: number, newListId: number, taskId: number) {
    const prevListIndex = store.project.lists.findIndex((x) => x.id === prevListId)
    const newListIndex = store.project.lists.findIndex((x) => x.id === newListId)
    const taskIndex = store.project.lists[prevListIndex].tasks.findIndex((x) => x.id === taskId)

    const task = store.project.lists[prevListIndex].tasks.splice(taskIndex, 1)[0]
    store.project.lists[newListIndex].tasks.push(task)
  }

  return {
    move,
  }
}
