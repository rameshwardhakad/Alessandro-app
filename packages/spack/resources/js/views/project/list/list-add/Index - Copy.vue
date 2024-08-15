<template>
  <Card class="mt-4 p-6">
    <input
      ref="input"
      type="text"
      class="block w-full rounded-md border-0 py-1.5 text-sm text-gray-900 shadow placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600"
      :placeholder="__('Enter list title...')"
      @keydown.enter="add"
    />

    <div class="mt-2 flex items-center">
      <button
        type="button"
        class="rounded bg-blue-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
        @click="add"
      >
        {{ __('Add task') }}
      </button>
      <button
        type="button"
        class="ml-1 rounded px-2 py-1 text-sm font-medium text-gray-600 hover:text-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
        @click="cancel"
      >
        {{ __('Cancel') }}
      </button>
    </div>
  </Card>

  <!--   <div class="group mt-2 flex cursor-pointer items-center">
    <PlusIcon class="h-4 w-4 text-gray-700 group-hover:text-gray-900" />

    <span class="ml-2 text-gray-700 group-hover:text-gray-900">
      {{ __('Add list') }}
    </span>
  </div> -->
</template>

<script setup lang="ts">
  // import { PlusIcon } from '@heroicons/vue/20/solid'
  import { Card } from 'thetheme'

  function add() {
    console.log('add')
  }

  function cancel() {
    console.log('cancel')
  }
</script>
