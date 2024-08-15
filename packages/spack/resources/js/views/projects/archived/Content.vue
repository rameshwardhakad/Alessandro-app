<template>
  <NoData v-if="!store.items.length" />

  <ul class="divide-y rounded-lg bg-white py-0 shadow">
    <li v-for="(item, index) in store.items" :key="item.id" class="flex items-center px-6 py-3">
      <div class="group flex flex-1 items-center">
        <span
          class="block h-2 w-2 flex-shrink-0 rounded-full"
          :style="{ 'background-color': item.meta.color }"
        />
        <span class="truncate text-gray-500 ltr:ml-3 rtl:mr-3">
          {{ item.name }}
        </span>
      </div>

      <div class="ltr:ml-auto rtl:mr-auto">
        <ProjectUnarchive v-if="can('project:unarchive')" :id="item.id" :index="index" />
      </div>
    </li>
  </ul>
</template>

<script setup lang="ts">
  import { useProjectArchivedStore } from 'Store/project-archived'
  import ProjectUnarchive from './ProjectUnarchive.vue'
  import NoData from '../NoData.vue'

  const store = useProjectArchivedStore()
</script>
