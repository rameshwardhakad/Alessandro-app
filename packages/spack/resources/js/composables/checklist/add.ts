import { nextTick, ref } from 'vue'
import { axios, generateTempId } from 'spack'
import { useTaskState } from 'Use/task'
import { useOnChecklistUpdate } from 'Use/project/onChecklistUpdate'
import { useChecklistEditForm } from './edit'

const text = ref<string>('')
const show = ref<boolean>(false)
const processing = ref<boolean>(false)
const input = ref<HTMLElement | null>(null)

export const useChecklistAddForm = () => {
  function open(): void {
    show.value = true
    useChecklistEditForm().close()
    nextTick(() => input.value?.focus())
  }

  function close(): void {
    show.value = false
  }

  async function submit(): Promise<void> {
    if (!text.value) return

    const { checklists, task } = useTaskState()

    const checklistItem = {
      id: 0,
      temp_id: generateTempId(),
      checklist_id: checklists.value[0].id,
      name: text.value,
      completed_at: null,
      order: checklists.value[0].items.length + 1,
    }

    checklists.value[0].items.push(checklistItem)

    axios
      .post(`/checklist-items`, {
        checklist_id: checklists.value[0].id,
        name: text.value,
        task_id: task.value.id,
        order: checklists.value[0].items.length + 1,
      })
      .then((response) => {
        checklists.value[0].id = response.data.model.checklist_id
        const checklistItemIndex = checklists.value[0].items.findIndex(
          (x) => x.temp_id === checklistItem.temp_id,
        )
        checklists.value[0].items[checklistItemIndex].id = response.data.model.id

        if (window.location.href.includes('/tasks')) return

        useOnChecklistUpdate().onAdd()
      })
      .catch((error) => {
        console.log(error)
        const checklistItemIndex = checklists.value[0].items.findIndex(
          (x) => x.temp_id === checklistItem.temp_id,
        )
        checklists.value[0].items.splice(checklistItemIndex, 1)
      })

    text.value = ''
  }

  return {
    text,
    show,
    processing,
    open,
    close,
    input,
    submit,
  }
}
