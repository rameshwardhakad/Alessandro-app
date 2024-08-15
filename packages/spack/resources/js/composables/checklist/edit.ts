import { nextTick, ref } from 'vue'
import { axios } from 'spack'
import { useTaskState } from 'Use/task'
import { useChecklistAddForm } from './add'

const text = ref<string>('')
const form = ref<number | null>(null)
const processing = ref<boolean>(false)
const input = ref<HTMLElement | null>(null)

export const useChecklistEditForm = () => {
  function open(index: number, name: string): void {
    form.value = index
    text.value = name
    processing.value = false
    useChecklistAddForm().close()
    nextTick(() => input.value?.focus())
  }

  function close(): void {
    form.value = null
  }

  async function submit(): Promise<void> {
    if (!text.value) return

    const { checklists } = useTaskState()
    const item = checklists.value[0].items[form.value as number]

    if (text.value === item.name) {
      close()
      return
    }

    processing.value = true

    axios
      .patch(`/checklist-items/${item.id}`, {
        name: text.value,
      })
      .then((response) => {
        item.name = response.data.model.name
        close()
        // const checklistItemIndex = checklists.value[0].items.findIndex(
        // (x) => x.temp_id === checklistItem.temp_id,
        // )
        // checklists.value[0].items[checklistItemIndex].id = response.data.model.id
      })
      .catch((error) => {
        console.log(error)
        // const checklistItemIndex = checklists.value[0].items.findIndex(
        //   (x) => x.temp_id === checklistItem.temp_id,
        // )
        // checklists.value[0].items.splice(checklistItemIndex, 1)
      })
  }

  return {
    text,
    processing,
    open,
    close,
    submit,
    form,
    input,
  }
}
