<template>
  <div
    class="mb-2 block cursor-pointer rounded-lg bg-white px-3 py-1 text-sm text-gray-700 shadow last:mb-0 hover:shadow-md"
    :data-id="task.id"
    :class="{
      'opacity-50': task.id == 0,
      'pointer-events-none': task.id == 0,
    }"
    @click="openModal(task.id)"
  >
    <span class="block py-1.5">{{ task.title }}</span>

    <div class="flex">
      <Duedate :date="task.human_due_date" />
      <Comments :comments="task.comments_count" />
      <Subtasks :completed="task.completed_subtasks_count" :subtasks="task.subtasks_count" />
      <Assignees :users="task.users" :plus="task.users_count" />
    </div>
  </div>
</template>

<script setup lang="ts">
  import type { ConcreteComponent } from 'vue'
  import TaskModal from 'View/task/Index.vue'
  import { useModalsStore } from 'spack'
  import Duedate from './Duedate.vue'
  import Subtasks from './Subtasks.vue'
  import Comments from './Comments.vue'
  import Assignees from './Assignees.vue'

  defineProps<{
    task: any
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
