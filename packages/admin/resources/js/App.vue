<template>
  <RouterView v-if="store.isBlankPage" />

  <Layout v-else />
</template>

<script setup lang="ts">
  import { useStore } from 'Store/main'
  import Layout from 'View/layouts/Layout.vue'

  const store = useStore()
</script>
