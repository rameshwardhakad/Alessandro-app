<template>
  <div
    class="flex h-6 w-6 max-w-none cursor-pointer items-center justify-center rounded-full border border-dashed border-gray-500 p-0 hover:border-gray-800 ltr:!ml-1.5 rtl:!mr-2.5"
    data-cooltipz-dir="bottom"
    :aria-label="__('Add/Remove Members')"
    @click="openModal"
  >
    <SquaresPlusIcon class="h-3 w-3 text-gray-600" />
  </div>
</template>

<script setup lang="ts">
  import Form from './Form.vue'
  import { useModalsStore } from 'spack'
  import { SquaresPlusIcon } from '@heroicons/vue/24/outline'

  function openModal(): void {
    useModalsStore().add(Form)
  }
</script>
