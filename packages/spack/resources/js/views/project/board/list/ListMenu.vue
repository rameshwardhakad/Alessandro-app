<template>
  <Dropdown close-outside>
    <template #trigger>
      <div
        class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg hover:bg-gray-300"
      >
        <EllipsisHorizontalIcon class="w-5" />
      </div>
    </template>

    <template #content>
      <div class="dropdown-card right mt-0">
        <div class="py-1">
          <button
            class="w-full px-4 py-1.5 text-left text-sm font-normal leading-5 text-gray-600 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
            @click="remove(id, index)"
          >
            {{ __('Delete') }}
          </button>
        </div>
      </div>
    </template>
  </Dropdown>
</template>

<script setup lang="ts">
  import { useListDelete } from 'Use/listDelete'
  import { EllipsisHorizontalIcon } from '@heroicons/vue/24/outline'
  import { Dropdown } from 'thetheme'

  const { remove } = useListDelete()

  defineProps<{
    id: number
    index: number
  }>()
</script>
