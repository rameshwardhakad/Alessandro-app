<template>
  <div v-if="fetching" class="mt-12 flex justify-center">
    <Loader color="text-gray-600" />
  </div>

  <PageContainer v-else>
    <h1 class="mb-5 text-2xl font-semibold text-gray-900">
      {{ __('Dashboard') }}
    </h1>

    <Metrics />

    <Charts />
  </PageContainer>
</template>

<script setup lang="ts">
  import { useHome } from 'Use/home'
  import { Loader, PageContainer } from 'thetheme'
  import Charts from './_Charts.vue'
  import Metrics from './_Metrics.vue'

  const { fetching, init } = useHome()

  init()
</script>
