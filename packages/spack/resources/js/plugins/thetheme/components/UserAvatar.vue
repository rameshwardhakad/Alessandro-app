<template>
  <span v-if="avatar" class="block rounded-full">
    <img :src="'/'+avatar" class="h-full w-full rounded-full" />
  </span>

  <span v-else class="inline-block rounded-full bg-gray-100 text-gray-300">
    <svg class="rounded-full" fill="currentColor" viewBox="0 0 24 24">
      <path
        d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
      />
    </svg>
  </span>
</template>

<script setup lang="ts">
  defineProps<{
    avatar: string | null
  }>()
</script>
