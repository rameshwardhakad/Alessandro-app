<template>
  <div ref="listAddForm" class="mt-4 rounded-lg bg-white px-4 pb-4 pt-3 shadow">
    <!-- <input
      type="text"
      class="block w-full rounded-lg border-0 py-2.5 text-sm text-gray-900 shadow placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600"
      :placeholder="__('Enter list title...')"
    /> -->

    <input
      ref="input"
      v-model="name"
      type="text"
      class="block w-full border-0 p-0 text-sm leading-7 text-gray-900 placeholder:text-gray-400 focus:border-transparent focus:ring-0"
      :placeholder="__('Enter list title...')"
      @keydown.enter="addList"
    />

    <div class="mt-3">
      <button
        type="button"
        class="rounded bg-blue-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
        @click="addList"
      >
        {{ __('Add list') }}
      </button>
      <button
        type="button"
        class="rounded px-2 py-1 text-sm font-medium text-gray-600 hover:text-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 ltr:ml-1 rtl:mr-1"
        @click="hideForm"
      >
        {{ __('Cancel') }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { onMounted } from 'vue'
  import { onClickOutside, onKeyStroke } from '@vueuse/core'
  import { useListAdd } from 'Use/project/list-add'

  const { addList, focusInput, hideForm, input, listAddForm, name } = useListAdd('list-add-list')

  onMounted(() => focusInput())

  onClickOutside(listAddForm, () => hideForm())

  onKeyStroke('Escape', (e) => {
    e.preventDefault()
    hideForm()
  })
</script>
