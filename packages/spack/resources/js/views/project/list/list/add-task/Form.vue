<template>
  <div class="rounded-lg border px-4 pb-4 pt-3">
    <input
      ref="input"
      v-model="title"
      type="text"
      class="block w-full border-0 p-0 text-sm leading-7 text-gray-900 placeholder:text-gray-400 focus:border-transparent focus:ring-0"
      :placeholder="__('Enter task title...')"
      @keydown.enter="addTask(index)"
    />

    <div class="mt-3">
      <button
        type="button"
        class="rounded bg-blue-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
        @click="addTask(index)"
      >
        {{ __('Add task') }}
      </button>
      <button
        type="button"
        class="rounded px-2 py-1 text-sm font-medium text-gray-600 hover:text-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 ltr:ml-1 rtl:mr-1"
        @click="hideForm"
      >
        {{ __('Cancel') }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { onMounted } from 'vue'
  import { useTaskAdd } from 'Use/project/task-add'

  const { addTask, focusInput, hideForm, input, title } = useTaskAdd('task-add-list')

  defineProps<{
    index: number
  }>()

  onMounted(() => focusInput())
</script>
