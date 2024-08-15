<template>
  <Loader v-if="processing" size="16px" color="text-gray-500" />

  <span v-else aria-label="UnArchive" data-cooltipz-dir="top" @click="unarchive(id, index)">
    <ArchiveBoxXMarkIcon class="h-4 w-4 cursor-pointer text-gray-600 hover:text-gray-900" />
  </span>
</template>

<script setup lang="ts">
  import { ArchiveBoxXMarkIcon } from '@heroicons/vue/24/outline'
  import { useProjectUnarchive } from 'Use/project/unarchive'
  import { Loader } from 'thetheme'

  const { processing, unarchive } = useProjectUnarchive()

  defineProps<{
    id: number
    index: number
  }>()
</script>
