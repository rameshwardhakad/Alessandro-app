import { axios } from 'spack'
import { useTaskState } from './index'
import { useOnListUpdate } from 'Use/project/onListUpdate'

export const useTaskListUpdate = () => {
  async function update(option: SelectOption) {
    const { list, task } = useTaskState()
    const prevList = list.value
    const newList = { id: option.value as number, name: option.label }

    list.value = newList

    await axios.patch(`/tasks/${task.value.id}/list`, {
      project_list_id: newList.id,
    })
    // const projectDetailStore = useProjectDetailStore()

    if (window.location.href.includes('/tasks')) return

    useOnListUpdate().move(prevList.id, newList.id, task.value.id)
  }

  return {
    update,
  }
}
