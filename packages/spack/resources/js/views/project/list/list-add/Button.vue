<template>
  <div class="group flex cursor-pointer items-center" @click="showForm">
    <PlusIcon class="h-4 w-4 text-gray-700 group-hover:text-gray-900" />

    <span class="text-sm text-gray-700 group-hover:text-gray-900 ltr:ml-2 rtl:mr-2">
      {{ __('Add list') }}
    </span>
  </div>
</template>

<script setup lang="ts">
  import { useListAdd } from 'Use/project/list-add'
  import { PlusIcon } from '@heroicons/vue/24/solid'

  const { showForm } = useListAdd('list-add-list')
</script>
