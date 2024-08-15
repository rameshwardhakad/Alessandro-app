<template>
  <div v-show="comments" class="flex items-center ltr:mr-2.5 rtl:ml-2.5">
    <ChatBubbleOvalLeftEllipsisIcon class="h-4 w-4 text-gray-400" />

    <span class="text-xs tracking-widest text-gray-500 ltr:ml-0.5 rtl:mr-0.5">
      {{ comments }}
    </span>
  </div>
</template>

<script setup lang="ts">
  import { ChatBubbleOvalLeftEllipsisIcon } from '@heroicons/vue/24/outline'

  defineProps<{
    comments: number
  }>()
</script>
