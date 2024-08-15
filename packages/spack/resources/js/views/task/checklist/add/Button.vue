<template>
  <button class="group mt-4 flex items-center" @click="open">
    <PlusIcon class="h-4 w-4 text-gray-600 group-hover:text-gray-800" />
    <span class="text-sm text-gray-600 group-hover:text-gray-800 ltr:pl-2 rtl:pr-2">
      {{ __('Add item') }}
    </span>
  </button>
</template>

<script setup lang="ts">
  import { PlusIcon } from '@heroicons/vue/24/solid'
  import { useChecklistAddForm } from 'Use/checklist/add'

  const { open } = useChecklistAddForm()
</script>
