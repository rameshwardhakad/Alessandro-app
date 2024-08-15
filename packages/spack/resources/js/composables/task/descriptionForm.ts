import { ref } from 'vue'
import { axios, cannot } from 'spack'
import { useTaskState } from './index'

const isForm = ref<boolean>(false)
const processing = ref<boolean>(false)
const text = ref<string>('')

export const useTaskDescriptionForm = () => {
  const { task } = useTaskState()

  function init() {
    isForm.value = false
    processing.value = false
    text.value = ''
  }

  function showForm() {
    if (cannot('task:update')) return

    isForm.value = true
    text.value = task.value.description
  }

  function cancel() {
    isForm.value = false
    processing.value = false
  }

  function save() {
    console.log('save')
    processing.value = true

    axios
      .patch(`/tasks/${task.value.id}/description`, {
        description: text.value,
      })
      .then(() => {
        // task.update(data)
        task.value.description = text.value
        cancel()
      })
      .catch(() => {
        processing.value = false
      })
  }

  return {
    isForm,
    showForm,
    cancel,
    processing,
    text,
    save,
    init,
  }
}
