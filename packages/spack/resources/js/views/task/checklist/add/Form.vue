<template>
  <div class="mt-4 flex">
    <input
      ref="input"
      v-model="text"
      type="text"
      class="item-input block w-full flex-1 rounded-none border-gray-300 py-2 text-sm leading-none focus:border-gray-300 focus:ring-0 disabled:opacity-50 ltr:rounded-l-md rtl:rounded-r-md"
      :placeholder="__('Enter checklist item')"
      @keyup.enter="submit"
      @keydown.esc="close"
    />

    <button
      type="button"
      class="relative inline-flex items-center space-x-2 border border-gray-300 bg-gray-50 px-4 py-1 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-gray-300 focus:outline-none focus:ring-0 disabled:opacity-50 ltr:-ml-px rtl:-mr-px rtl:space-x-reverse"
      @click="close"
    >
      <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M6 18L18 6M6 6l12 12"
        />
      </svg>
    </button>

    <button
      type="button"
      class="relative inline-flex items-center space-x-2 border border-gray-300 bg-gray-50 px-4 py-1 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-gray-300 focus:outline-none focus:ring-0 disabled:opacity-50 ltr:-ml-px ltr:rounded-r-md rtl:-mr-px rtl:space-x-reverse rtl:rounded-l-md"
      @click="submit"
    >
      <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
    </button>
  </div>
</template>

<script setup lang="ts">
  import { useChecklistAddForm } from 'Use/checklist/add'

  const { close, input, submit, text } = useChecklistAddForm()
</script>
