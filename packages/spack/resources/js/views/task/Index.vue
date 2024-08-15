<template>
  <ModalBase width="max-w-3xl">
    <div v-if="fetching" class="page-loader py-40">
      <Loader color="text-gray-400" />
    </div>

    <MainContent v-else />
  </ModalBase>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'
  import { Loader, ModalBase } from 'thetheme'
  import MainContent from './MainContent.vue'

  const { id } = defineProps<{
    id: number
  }>()

  const { fetch, fetching } = useTaskState()

  fetch(id)
</script>
