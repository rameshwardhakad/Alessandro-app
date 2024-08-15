import { computed, ref } from 'vue'
import { useTaskState } from 'Use/task'
import { axios, generateTempId } from 'spack'
import { useProjectDetailStore } from 'Store/project-detail'
import { useOnChecklistUpdate } from 'Use/project/onChecklistUpdate'

const isForm = ref<boolean>(false)
const formText = ref<string>('')
const editForm = ref<number | null>(null)

export const useChecklist = () => {
  const { checklists } = useTaskState()

  const countItems = computed(() => {
    if (!checklists.value.length) return

    return (
      checklists.value[0].items.filter((x: any) => x.completed_at).length +
      '/' +
      checklists.value[0].items.length
    )
  })

  async function toggleState(id: number, index: number) {
    const { checklists } = useTaskState()

    const state = checklists.value[0].items[index].completed_at

    state
      ? (checklists.value[0].items[index].completed_at = null)
      : (checklists.value[0].items[index].completed_at = new Date().toISOString())

    axios.patch(`/checklist-items/${id}/toggle`).then(() => {
      if (window.location.href.includes('/tasks')) return

      useOnChecklistUpdate().onToggle(state)
    })
  }

  async function addItem() {
    console.log('hit addItem')
    const { checklists, list, task } = useTaskState()

    if (!formText.value) return

    const checklistItem = {
      id: 0,
      temp_id: generateTempId(),
      checklist_id: checklists.value[0].id,
      name: formText.value,
      completed_at: null,
      order: checklists.value[0].items.length + 1,
    }

    checklists.value[0].items.push(checklistItem)

    axios
      .post(`/checklist-items`, {
        checklist_id: checklists.value[0].id,
        name: formText.value,
        task_id: task.value.id,
        order: checklists.value[0].items.length + 1,
      })
      .then((response) => {
        checklists.value[0].id = response.data.model.checklist_id
        const checklistItemIndex = checklists.value[0].items.findIndex(
          (x) => x.temp_id === checklistItem.temp_id,
        )
        checklists.value[0].items[checklistItemIndex].id = response.data.model.id

        const store = useProjectDetailStore()

        const listIndex = store.project.lists.findIndex((x) => x.id === list.value.id)
        const taskIndex = store.project.lists[listIndex].tasks.findIndex(
          (x) => x.id === task.value.id,
        )

        store.project.lists[listIndex].tasks[taskIndex].subtasks_count += 1
      })
      .catch((error) => {
        console.log(error)
        const checklistItemIndex = checklists.value[0].items.findIndex(
          (x) => x.temp_id === checklistItem.temp_id,
        )
        checklists.value[0].items.splice(checklistItemIndex, 1)
      })

    formText.value = ''
  }

  function hideEditForm() {
    editForm.value = null
    formText.value = ''
  }

  function editItem(index: number, item: string) {
    editForm.value = index
    formText.value = item
    hideForm()
  }

  function showForm() {
    isForm.value = true
    hideEditForm()
  }

  function hideForm() {
    isForm.value = false
  }

  return {
    isForm,
    showForm,
    formText,
    addItem,
    editForm,
    hideEditForm,
    countItems,
    editItem,
    toggleState,
    hideForm,
  }
}
