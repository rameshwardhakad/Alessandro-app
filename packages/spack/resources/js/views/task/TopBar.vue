<template>
  <div class="flex border-b border-gray-200 shadow-sm">
    <div class="flex items-center px-6 text-sm text-gray-700">
      <span
        class="inline-block h-2.5 w-2.5 rounded-full ltr:mr-4 rtl:ml-4"
        :style="{ 'background-color': project.meta.color }"
      >
        &nbsp;
      </span>
      <span>{{ project.name }}</span>
      <span class="px-2">/</span>
      <span>{{ list.name }}</span>
    </div>

    <div class="flex items-center ltr:ml-auto rtl:mr-auto">
      <span
        class="m-2.5 cursor-pointer rounded-full p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800"
        @click="taskModal.close"
      >
        <svg class="h-5 w-5" viewBox="0 0 21 21">
          <g
            fill="none"
            fill-rule="evenodd"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            transform="translate(5 5)"
          >
            <path d="m10.5 10.5-10-10z" />
            <path d="m10.5.5-10 10" />
          </g>
        </svg>
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'
  import { useTaskModal } from 'Use/taskModal'

  const taskModal = useTaskModal()

  const { list, project } = useTaskState()
</script>
