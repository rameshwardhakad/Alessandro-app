<template>
  <div v-show="subtasks" class="flex items-center py-1 ltr:mr-2.5 rtl:ml-2.5">
    <CheckCircleIcon class="h-4 w-4 text-gray-400" />

    <span class="text-xs tracking-widest text-gray-500 ltr:ml-0.5 rtl:mr-0.5">
      {{ completed }}/{{ subtasks }}
    </span>
  </div>
</template>

<script setup lang="ts">
  import { CheckCircleIcon } from '@heroicons/vue/24/outline'

  defineProps<{
    completed: number
    subtasks: number
  }>()
</script>
