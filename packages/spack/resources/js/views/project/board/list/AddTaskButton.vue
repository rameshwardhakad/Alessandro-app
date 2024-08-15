<template>
  <div
    class="mx-2 my-2 flex cursor-pointer items-center rounded-lg py-1.5 hover:bg-gray-300 ltr:pl-1.5 ltr:pr-2 rtl:pl-2 rtl:pr-1.5"
  >
    <PlusIcon class="h-4 w-4 text-gray-600 ltr:mr-1.5 rtl:ml-1.5" />
    <span class="text-sm text-gray-700">{{ __('Add task') }}</span>
  </div>
</template>

<script setup lang="ts">
  import { PlusIcon } from '@heroicons/vue/24/outline'
</script>
