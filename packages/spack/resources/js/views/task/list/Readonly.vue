<template>
  <div class="mt-2 flex items-center px-2 py-1">
    <span class="block text-xs leading-none text-gray-600">
      {{ list.name }}
    </span>
  </div>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'

  const { list } = useTaskState()
</script>
