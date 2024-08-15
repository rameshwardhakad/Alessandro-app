import { ref } from 'vue'
import { useProjectDetailStore } from 'Store/project-detail'
import { axios, defineComposable, generateTempId } from 'spack'

export function useTaskAdd(key: string) {
  return defineComposable(key, () => {
    const projectDetailStore = useProjectDetailStore()
    const isForm = ref<number | boolean | null>(null),
      title = ref<string>(''),
      input = ref<HTMLInputElement | null>(null),
      listAddWrapper = ref<HTMLInputElement | null>(null),
      listAddForm = ref<HTMLInputElement | null>(null)

    function showForm(index: number) {
      isForm.value = index
    }

    function hideForm() {
      isForm.value = null
      resetForm()
    }

    function addTask(index: number) {
      if (!title.value) return

      const task = {
        id: 0,
        temp_id: generateTempId(),
        project_id: projectDetailStore.project.id,
        project_list_id: projectDetailStore.project.lists[index].id,
        title: title.value,
        users: [],
        users_count: 0,
        comments_count: 0,
        subtasks_count: 0,
        completed_subtasks_count: 0,
        human_due_date: null,
        due_at: null,
      }

      axios
        .post(`tasks`, {
          project_id: projectDetailStore.project.id,
          project_list_id: projectDetailStore.project.lists[index].id,
          title: title.value,
        })
        .then(({ data }) => {
          const taskIndex = projectDetailStore.project.lists[index].tasks.findIndex(
            (item) => item.temp_id === task.temp_id,
          )
          projectDetailStore.project.lists[index].tasks[taskIndex]['id'] = data.model.id
        })
        .catch((error) => {
          console.log(error)
          const taskIndex = projectDetailStore.project.lists[index].tasks.findIndex(
            (item) => item.temp_id === task.temp_id,
          )
          projectDetailStore.project.lists[index].tasks.splice(taskIndex, 1)
        })

      projectDetailStore.project.lists[index].tasks.push(task)

      resetForm()
      focusInput()

      setTimeout(() => scrollForm(index))
    }

    function resetForm() {
      title.value = ''
    }

    function focusInput() {
      input.value?.focus()
    }

    function scrollForm(index: number) {
      const el = document.getElementById('add-task-wrapper-' + index)
      const bottom = (el?.offsetTop ?? 0) + (el?.offsetHeight ?? 0)
      const viewportBottom = window.scrollY + window.innerHeight - 200

      if (bottom > viewportBottom) {
        const scrollPosition =
          (el?.offsetTop ?? 0) - window.innerHeight + (el?.offsetHeight ?? 0) + 200

        window.scrollTo({
          top: scrollPosition,
          behavior: 'smooth',
        })
      }
    }

    return {
      addTask,
      focusInput,
      hideForm,
      input,
      isForm,
      listAddForm,
      listAddWrapper,
      title,
      showForm,
    }
  })
}
