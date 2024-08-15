import { ref } from 'vue'
import { useProjectDetailStore } from 'Store/project-detail'
import { axios, defineComposable, generateTempId } from 'spack'

export function useListAdd(key: string) {
  return defineComposable(key, () => {
    const projectDetailStore = useProjectDetailStore()
    const isForm = ref<boolean>(false),
      name = ref<string>(''),
      input = ref<HTMLInputElement | null>(null),
      listAddWrapper = ref<HTMLInputElement | null>(null),
      listAddForm = ref<HTMLInputElement | null>(null)

    function showForm() {
      isForm.value = true
    }

    function hideForm() {
      isForm.value = false
      resetForm()
    }

    function addList() {
      if (!name.value) return

      const list = {
        id: 0,
        temp_id: generateTempId(),
        project_id: projectDetailStore.project.id,
        name: name.value,
        tasks: [],
      }

      projectDetailStore.project.lists.push(list)

      axios
        .post(`/project-lists`, list)
        .then(({ data }) => {
          const listIndex = projectDetailStore.project.lists.findIndex(
            (item) => item.temp_id === list.temp_id,
          )
          projectDetailStore.project.lists[listIndex]['id'] = data.model.id
        })
        .catch((error) => {
          console.log(error)
          const listIndex = projectDetailStore.project.lists.findIndex(
            (item) => item.temp_id === list.temp_id,
          )
          projectDetailStore.project.lists.splice(listIndex, 1)
        })

      resetForm()
      focusInput()

      setTimeout(() => listAddWrapper.value?.scrollIntoView())
    }

    function resetForm() {
      name.value = ''
    }

    function focusInput() {
      input.value?.focus()
    }

    return {
      addList,
      focusInput,
      hideForm,
      input,
      isForm,
      listAddForm,
      listAddWrapper,
      name,
      showForm,
    }
  })
}
