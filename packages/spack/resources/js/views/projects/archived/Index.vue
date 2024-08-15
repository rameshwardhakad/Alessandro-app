<template>
  <ContentFetching v-if="store.fetching"/>

  <Content v-else />
</template>

<script setup lang="ts">
  import { useProjectArchivedStore } from 'Store/project-archived'
  import ContentFetching from '../ContentFetching.vue'
  import Content from './Content.vue'

  const store = useProjectArchivedStore()

  store.fetch()
</script>
