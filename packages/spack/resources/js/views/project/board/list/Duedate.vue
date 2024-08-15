<template>
  <div v-show="date" class="flex items-center py-1 ltr:mr-2.5 rtl:ml-2.5">
    <CalendarIcon class="h-4 w-4 text-gray-400" />
    <span class="text-xs text-gray-500 ltr:ml-1 rtl:mr-1" v-text="date"></span>
  </div>
</template>

<script setup lang="ts">
  import { CalendarIcon } from '@heroicons/vue/24/outline'

  defineProps<{
    date: string | null
  }>()
</script>
