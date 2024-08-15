<template>
  <div class="rounded-md border border-gray-300 p-3">
    <textarea
      ref="textarea"
      v-model="text"
      class="autosize task-description block h-10 w-full resize-none border-0 p-0 text-sm text-gray-600 placeholder:font-normal placeholder:text-gray-500 focus:ring-0"
      placeholder="Description"
      @keydown.ctrl.enter="save"
      @keydown.esc="cancel"
    />

    <div class="flex items-center pt-4">
      <button
        type="button"
        class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-0 enabled:hover:bg-gray-50 disabled:opacity-50"
        :disabled="processing"
        @click="save"
      >
        {{ __('Save') }}
        <Loader v-if="processing" size="12px" class="ltr:ml-2 rtl:mr-2" />
      </button>

      <button
        type="button"
        class="inline-flex items-center rounded border border-transparent bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-0 disabled:opacity-50 ltr:ml-1 rtl:mr-1"
        :disabled="processing"
        @click="cancel"
      >
        {{ __('Cancel') }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { onMounted, ref } from 'vue'
  import autosize from 'autosize'
  import { useTaskDescriptionForm } from 'Use/task/descriptionForm'
  import { Loader } from 'thetheme'

  const textarea = ref<HTMLElement | null>(null)
  const { cancel, processing, save, text } = useTaskDescriptionForm()

  onMounted(() => {
    textarea.value?.focus()

    autosize(textarea.value as HTMLElement)
  })
</script>
