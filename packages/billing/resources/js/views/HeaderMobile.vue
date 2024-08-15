<template>
  <a
    href="/app"
    id="topNavReturnLink"
    class="flex w-full items-center bg-white px-4 py-4 shadow-lg lg:hidden"
  >
    <svg viewBox="0 0 20 20" fill="currentColor" class="arrow-left h-4 w-4 text-gray-400">
      <path
        fill-rule="evenodd"
        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
        clip-rule="evenodd"
      />
    </svg>

    <div class="ml-2 text-gray-600 underline">{{ __('Return to') }} {{ appData.app_name }}</div>
  </a>
</template>

<script setup lang="ts">
  import { appData } from '@/app-data'
</script>
