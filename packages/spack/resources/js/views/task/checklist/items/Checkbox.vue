<template>
  <span
    class="mt-px inline-block h-5 w-5 cursor-pointer rounded-full text-white ltr:mr-2 rtl:ml-2"
    :class="{
      'bg-blue-400': isCompleted,
      'border border-gray-300 bg-white': !isCompleted,
    }"
    @click="toggleState(id, index)"
  >
    <svg viewBox="0 0 16 16" fill="white">
      <path
        d="M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z"
      />
    </svg>
  </span>
</template>

<script setup lang="ts">
  import { useChecklist } from 'Use/checklist'

  defineProps<{
    id: number
    index: number
    isCompleted: string | null
  }>()

  const { toggleState } = useChecklist()
</script>
