<template>
  <div v-if="store.fetching" class="page-loader">
    <Loader color="text-gray-400" />
  </div>

  <MainContent v-else />
</template>

<script setup lang="ts">
  import { useProjectDetailStore } from 'Store/project-detail'
  import { Loader } from 'thetheme'
  import MainContent from './MainContent.vue'
  import { onBeforeRouteUpdate } from 'vue-router'

  const { id } = defineProps<{
    id: string
  }>()

  const store = useProjectDetailStore()

  store.fetch(id)

  onBeforeRouteUpdate((to, from) => {
    console.log('onBeforeRouteUpdate!')
    console.log(to)
    console.log(from)
    if (to.params.id !== from.params.id) {
      store.fetch(to.params.id as string)
    }
  })
</script>
