<template>
  <div v-if="indexTask.fetching" class="mt-12 flex justify-center">
    <Loader color="text-gray-600" />
  </div>

  <PageContainer v-else class="pb-12">
    <div class="mb-4 flex">
      <h1 class="text-2xl font-semibold text-gray-900">{{ __('My Tasks') }}</h1>
    </div>

    <NoData v-if="Array.isArray(indexTask.data)" />

    <div v-else class="space-y-4">
      <TasksList v-if="indexTask.data['today']" title="Today" :tasks="indexTask.data['today']" />
      <TasksList
        v-if="indexTask.data['overdue']"
        title="Overdue"
        :tasks="indexTask.data['overdue']"
      />
      <TasksList
        v-if="indexTask.data['upcoming']"
        title="Upcoming"
        :tasks="indexTask.data['upcoming']"
      />
      <TasksList
        v-if="indexTask.data['no due date']"
        title="No due date"
        :tasks="indexTask.data['no due date']"
      />
    </div>
  </PageContainer>
</template>

<script setup lang="ts">
  import { useIndexStore } from 'spack'
  import { Loader, PageContainer } from 'thetheme'
  import NoData from './NoData.vue'
  import TasksList from './TasksList.vue'

  const indexTask = useIndexStore('tasks')()

  indexTask.setConfig({
    uri: 'tasks',
  })

  indexTask.fetch()
</script>
