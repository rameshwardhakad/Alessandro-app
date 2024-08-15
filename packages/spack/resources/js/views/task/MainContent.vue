<template>
  <TopBar />

  <div class="flex">
    <main class="flex-1 px-6 pb-8 pt-6">
      <TaskTitle />
      <TaskDescription />
      <Checklist />
      <!-- <TaskAttachments /> -->
      <TaskComments />
    </main>

    <aside class="w-60 divide-y divide-gray-200 rounded-br-lg bg-gray-50 px-6 py-6">
      <TaskList />
      <TaskDueDate />
      <TaskMembers />
      <!-- <TaskLabels /> -->
      <TaskDelete v-if="can('task:delete')" />
      <!-- <TaskShare /> -->
    </aside>
  </div>
</template>

<script setup lang="ts">
  import TopBar from './TopBar.vue'
  import TaskTitle from './TaskTitle.vue'
  import TaskDescription from './description/Index.vue'
  import TaskList from './list/Index.vue'
  import Checklist from './checklist/Index.vue'
  import TaskComments from './comments/Index.vue'
  // import TaskAttachments from './attachments/Index.vue'
  import TaskMembers from './members/Index.vue'
  import TaskDelete from './delete/Index.vue'
  // import TaskShare from './share/Index.vue'
  // import TaskLabels from './labels/Index.vue'
  import TaskDueDate from './duedata/Index.vue'
</script>
