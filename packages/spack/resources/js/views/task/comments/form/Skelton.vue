<template>
  <div
    class="mb-4 mt-1 cursor-pointer rounded-md border border-gray-300 hover:shadow"
    @click="show"
  >
    <p class="px-3 py-2 text-sm text-gray-500">{{ __('Write a comment') }}</p>
  </div>
</template>

<script setup lang="ts">
  import { useCommentForm } from 'Use/comment/form'

  const { show } = useCommentForm()
</script>
