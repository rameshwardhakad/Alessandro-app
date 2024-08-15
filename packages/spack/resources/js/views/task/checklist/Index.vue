<template>
  <section class="mt-8">
    <Collapsible name="task-checklist" :open="true">
      <template #trigger="{ open }">
        <div class="flex">
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

          <div class="flex-1 border-b pb-2">
            <span class="text-sm font-medium text-gray-800">
              {{ __('Checklist') }}
            </span>
            <span class="text-sm font-light text-gray-600 ltr:ml-2 rtl:mr-2">
              {{ countItems }}
            </span>
          </div>
        </div>
      </template>

      <template #content>
        <div class="ltr:pl-8 rtl:pr-8">
          <Items />
          <Add />
        </div>
      </template>
    </Collapsible>
  </section>
</template>

<script setup lang="ts">
  import { useChecklist } from 'Use/checklist'
  import { Collapsible } from 'thetheme'
  import Items from './items/Index.vue'
  import Add from './add/Index.vue'

  const { countItems } = useChecklist()
</script>
