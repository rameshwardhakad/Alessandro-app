<template>
  <section class="py-3.5">
    <div class="flex items-center px-2">
      <h2 class="text-sm font-medium text-gray-600">{{ __('Assignee') }}</h2>

      <TaskAssign v-if="can('task:update')" class="ltr:ml-auto rtl:mr-auto" />
    </div>

    <div v-if="users.length" class="flex flex-wrap px-2 pt-2">
      <UserAvatar
        v-for="user in users"
        :key="user.id"
        data-cooltipz-dir="top"
        :aria-label="user.name"
        class="mb-1 h-6 w-6 border-2 border-white ltr:mr-1 rtl:ml-1"
        :avatar="user.avatar"
      />
    </div>
  </section>
</template>

<script setup lang="ts">
  import { UserAvatar } from 'thetheme'
  import { useTaskState } from 'Use/task'
  import TaskAssign from './TaskAssign.vue'

  const { users } = useTaskState()
</script>
