<template>
  <form class="mb-4 mt-1 rounded-md border border-gray-300" enctype="multipart/form-data">
    <textarea
      ref="input"
      v-model="text"
      class="autosize comment-textarea block max-h-40 w-full resize-none rounded-md border-0 text-sm focus:ring-0"
      :placeholder="__('Write a comment')"
      @keydown.ctrl.enter="create"
      @keydown.esc="cancel"
    />

    <Files />

    <div class="flex items-center px-3 pb-3 pt-2">
      <div class="flex items-center">
        <button
          type="button"
          class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-0 enabled:hover:bg-gray-50 disabled:opacity-50"
          :disabled="isSubmitting"
          @click="create"
        >
          {{ __('Save') }}
          <Loader v-if="isSubmitting" size="12px" class="ml-2" />
        </button>

        <button
          type="button"
          class="inline-flex items-center rounded border border-transparent bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-0 disabled:opacity-50 ltr:ml-1 rtl:mr-1"
          :disabled="isSubmitting"
          @click="cancel"
        >
          {{ __('Cancel') }}
        </button>
      </div>

      <div class="flex ltr:ml-auto rtl:mr-auto">
        <label class="cursor-pointer">
          <input
            type="file"
            class="hidden"
            accept="image/png, image/jpeg, image/gif,.doc,.docx,.pdf,.txt"
            multiple
            @change="onFileInput"
          />

          <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
            />
          </svg>
        </label>
      </div>
    </div>
  </form>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { useCommentForm } from 'Use/comment/form'
  import Files from './Files.vue'
  import { Loader } from 'thetheme'

  const input = ref<HTMLElement | null>(null)
  const { cancel, create, isSubmitting, onFileInput, reset, text } = useCommentForm()

  reset()

  setTimeout(() => input.value?.focus())
</script>
