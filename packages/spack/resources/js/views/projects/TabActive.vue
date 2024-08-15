<template>
  <div v-if="store.fetching" class="mt-8 flex justify-center">
    <Loader size="40px" color="text-gray-500" />
  </div>

  <NoData v-if="!store.items.length && !store.fetching" />

  <ProjectsList v-if="store.items.length && !store.fetching" />
</template>

<script setup lang="ts">
  import { useProjectIndexStore } from 'Store/project-index'
  import { Loader } from 'thetheme'
  import NoData from './NoData.vue'
  import ProjectsList from './ProjectsList.vue'

  const store = useProjectIndexStore()

  store.fetch()
</script>
