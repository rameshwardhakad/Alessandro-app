<template>
  <div class="flex items-center">
    <InboxStackIcon class="h-4 w-4 text-gray-500 ltr:mr-4 rtl:ml-4" />

    <h2
      v-if="can('task:update')"
      ref="heading"
      :contenteditable="isEditing"
      class="flex-1 cursor-text rounded text-base/8 font-semibold text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-600 ltr:focus:-ml-2.5 ltr:focus:pl-2.5 rtl:focus:-mr-2.5 rtl:focus:pr-2.5"
      @click="edit"
      @blur="update"
      @keydown.enter="onEnter"
    >
      {{ task.title }}
    </h2>

    <h2
      v-else
      ref="heading"
      class="flex-1 cursor-text rounded text-base/8 font-semibold text-gray-800"
    >
      {{ task.title }}
    </h2>
  </div>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'
  import { useTaskTitle } from 'Use/task/title'
  import { InboxStackIcon } from '@heroicons/vue/24/outline'

  const { task } = useTaskState()
  const { edit, heading, isEditing, onEnter, update } = useTaskTitle()
</script>
