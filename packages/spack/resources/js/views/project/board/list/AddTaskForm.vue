<template>
  <div ref="taskAddForm" class="py-2">
    <textarea
      ref="textarea"
      v-model="title"
      class="autosize block w-full rounded-lg border-0 pb-5 pt-2 text-sm text-gray-900 shadow placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600"
      placeholder="Enter task title..."
      @keydown.enter="add"
    />
    <div class="mt-2 flex items-center">
      <button
        type="button"
        class="rounded bg-blue-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
        @click="add"
      >
        {{ __('Add task') }}
      </button>
      <button
        type="button"
        class="rounded px-2 py-1 text-sm font-medium text-gray-600 hover:text-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 ltr:ml-1 rtl:mr-1"
        @click="cancel"
      >
        {{ __('Cancel') }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { onMounted, ref } from 'vue'
  import autosize from 'autosize'
  import { useList } from 'Use/list'
  import { onClickOutside, onKeyStroke } from '@vueuse/core'
  import { useProjectDetailStore } from '@/stores/project-detail'
  import { axios, generateTempId } from 'spack'

  const emits = defineEmits(['after-add'])
  const textarea = ref<HTMLInputElement | null>(null)
  const taskAddForm = ref<HTMLDivElement | null>(null)
  const { isAddTaskForm } = useList()
  const title = ref('')
  const projectDetailStore = useProjectDetailStore()

  const { index } = defineProps<{
    index: number
  }>()

  onMounted(() => {
    autosize(document.querySelectorAll('.autosize'))
    textarea.value?.focus()
  })

  onClickOutside(taskAddForm, () => cancel())

  onKeyStroke('Escape', (e) => {
    e.preventDefault()
    cancel()
  })

  function add() {
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

    setTimeout(() => {
      emits('after-add')
      title.value = ''
    })
  }

  function cancel() {
    console.log('hit cancel')
    isAddTaskForm.value = null
    title.value = ''
  }
</script>
