<template>
  <Loader v-if="processing" size="16px" color="text-gray-500" />

  <span
    v-else
    aria-label="Delete"
    data-cooltipz-dir="top"
    class="hidden group-hover:block"
    @click="deleteIt(id, index)"
  >
    <TrashIcon class="h-4 w-4 cursor-pointer text-gray-600 hover:text-gray-900" />
  </span>
</template>

<script setup lang="ts">
  import { useChecklistItemDelete } from 'Use/checklist/delete'
  import { Loader } from 'thetheme'
  import { TrashIcon } from '@heroicons/vue/24/outline'

  const { deleteIt, processing } = useChecklistItemDelete()

  defineProps<{
    id: number
    index: number
  }>()
</script>
