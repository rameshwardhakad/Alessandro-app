<template>
  <div class="group flex cursor-pointer items-center" @click="showForm(index)">
    <PlusIcon class="h-4 w-4 text-gray-600 group-hover:text-gray-900" />

    <span class="text-sm text-gray-600 group-hover:text-gray-900 ltr:ml-2 rtl:mr-2">
      {{ __('Add task') }}
    </span>
  </div>
</template>

<script setup lang="ts">
  import { useTaskAdd } from 'Use/project/task-add'
  import { PlusIcon } from '@heroicons/vue/24/solid'

  const { showForm } = useTaskAdd('task-add-list')

  defineProps<{
    index: number
  }>()
</script>
