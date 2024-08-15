<template>
  <div
    class="group px-6"
    :data-id="task.id"
    :class="{
      'opacity-50': task.id == 0,
      'pointer-events-none': task.id == 0,
    }"
  >
    <div class="relative border-b py-3" @click="openModal(task.id)">
      <div
        v-if="can('task:move')"
        class="absolute hidden h-5 w-5 cursor-grab items-center justify-center rounded pt-0.5 text-gray-500 hover:text-gray-800 group-hover:flex ltr:-left-[1.375rem] rtl:-right-[1.375rem]"
      >
        <svg class="h-3" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path
            fill="currentColor"
            d="M10,4c0,1.1-0.9,2-2,2S6,5.1,6,4s0.9-2,2-2S10,2.9,10,4z M16,2c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S17.1,2,16,2z M8,10 c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S9.1,10,8,10z M16,10c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S17.1,10,16,10z M8,18 c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S9.1,18,8,18z M16,18c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S17.1,18,16,18z"
          />
        </svg>
      </div>

      <div class="flex cursor-pointer items-center">
        <!-- <input
          type="checkbox"
          class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-0 focus:ring-offset-0"
        /> -->
        <h3 class="text-sm text-gray-700 ltr:pl-0 rtl:pr-0">{{ task.title }}</h3>

        <div class="ltr:ml-auto rtl:mr-auto">
          <Assignees :users="task.users" />
        </div>
      </div>

      <div class="flex items-center pt-2 ltr:pl-0 rtl:pr-0">
        <Duedate :date="task.human_due_date" />
        <Comments :comments="task.comments_count" />
        <Subtasks :completed="task.completed_subtasks_count" :subtasks="task.subtasks_count" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import type { ConcreteComponent } from 'vue'
  import { useModalsStore } from 'spack'
  import TaskModal from 'View/task/Index.vue'
  import Assignees from './Assignees.vue'
  import Duedate from './Duedate.vue'
  import Comments from './Comments.vue'
  import Subtasks from './Subtasks.vue'

  defineProps<{
    task: any
    index: number
  }>()

  function openModal(id = null) {
    // const url = `/projects/${props.task.project_id}/tasks/${id}`
    // history.replaceState(history.state, '', url)

    useModalsStore().add(TaskModal as ConcreteComponent, {
      id,
      width: 'max-w-3xl',
    })
  }
</script>
