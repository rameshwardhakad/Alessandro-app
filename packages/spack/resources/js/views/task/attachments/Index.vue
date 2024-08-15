<template>
  <section class="mt-8">
    <Collapsible name="task-attachments" :open="true" custom-trigger>
      <template #trigger="{ open, toggle }">
        <div class="flex">
          <span @click="toggle">
            <svg
              class="mt-1 h-4 w-4 cursor-pointer text-gray-500 ltr:mr-4 rtl:ml-4"
              :class="{ 'rotate-[270deg]': !open }"
              viewBox="0 0 16 16"
            >
              <path
                d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758"
                fill="currentColor"
              />
            </svg>
          </span>

          <div class="flex flex-1 items-center border-b pb-2">
            <span class="text-sm font-medium text-gray-800">{{ __('Attachments') }} </span>
            <span class="text-sm font-light text-gray-600 ltr:ml-2 rtl:mr-2">
              {{ attachments.length }}
            </span>

            <AttachmentAdd />
          </div>
        </div>
      </template>

      <template #content>
        <div class="ltr:pl-8 rtl:pr-8">
          <AttachmentItems v-if="attachments.length"/>
        </div>
      </template>
    </Collapsible>
  </section>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'
  import { Collapsible } from 'thetheme'
  import AttachmentAdd from './add/Index.vue'
  import AttachmentItems from './items/Index.vue'

  const { attachments } = useTaskState()
</script>
