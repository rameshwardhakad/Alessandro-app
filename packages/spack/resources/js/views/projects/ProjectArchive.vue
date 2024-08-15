<template>
  <Loader v-if="processing" size="16px" color="text-gray-500" />

  <span v-else aria-label="Archive" data-cooltipz-dir="top" @click="archive(id, index)">
    <ArchiveBoxIcon class="h-4 w-4 cursor-pointer text-gray-600 hover:text-gray-900" />
  </span>
</template>

<script setup lang="ts">
  import { ArchiveBoxIcon } from '@heroicons/vue/24/outline'
  import { useProjectArchive } from 'Use/project/archive'
  import { Loader } from 'thetheme'

  const { archive, processing } = useProjectArchive()

  defineProps<{
    id: number
    index: number
  }>()
</script>
