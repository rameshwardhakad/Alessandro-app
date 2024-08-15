<template>
  <div
    ref="listAddForm"
    class="box-border flex max-h-full flex-col overflow-hidden whitespace-normal rounded-xl bg-gray-200 p-2"
  >
    <input
      ref="input"
      v-model="name"
      type="text"
      class="block w-full rounded-md border-0 py-1.5 text-sm text-gray-900 shadow placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600"
      :placeholder="__('Enter list title...')"
      @keydown.enter="addList"
    />

    <div class="mt-2 flex items-center">
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
  import { useListAdd } from 'Use/list-add'

  const { addList, focusInput, hideForm, input, listAddForm, name } = useListAdd()

  onMounted(() => focusInput())

  onClickOutside(listAddForm, () => hideForm())

  onKeyStroke('Escape', (e) => {
    e.preventDefault()
    hideForm()
  })
</script>
