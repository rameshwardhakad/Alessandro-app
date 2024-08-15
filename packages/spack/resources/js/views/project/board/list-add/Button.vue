<template>
  <div
    class="flex h-11 cursor-pointer items-center rounded-xl border border-dashed border-gray-500 px-4 hover:border-gray-800"
    @click="showForm"
  >
    <PlusIcon class="h-4 w-4 text-gray-600 ltr:mr-1.5 rtl:ml-1.5" />
    <span class="text-sm text-gray-700">{{ __('Add list') }}</span>
  </div>
</template>

<script setup lang="ts">
  import { useListAdd } from 'Use/project/list-add'
  import { PlusIcon } from '@heroicons/vue/24/solid'

  const { showForm } = useListAdd('list-add-board')
</script>
