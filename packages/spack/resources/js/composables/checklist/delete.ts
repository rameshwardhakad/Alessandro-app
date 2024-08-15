import { ref } from 'vue'
import { axios } from 'spack'
import { useTaskState } from 'Use/task'
import { useOnChecklistUpdate } from 'Use/project/onChecklistUpdate'

export const useChecklistItemDelete = () => {
  const processing = ref<boolean>(false)

  async function deleteIt(id: number, index: number) {
    processing.value = true

    await axios.delete(`/checklist-items/${id}`)

    const { checklists } = useTaskState()

    checklists.value[0].items.splice(index, 1)

    if (window.location.href.includes('/tasks')) return

    useOnChecklistUpdate().onDelete()
  }

  return {
    deleteIt,
    processing,
  }
}
