<template>
  <div v-if="store.fetching" class="mt-8 flex justify-center">
    <Loader />
  </div>

  <NoData v-if="!store.items.length && !store.fetching" />

  <ul
    v-if="store.items.length && !store.fetching"
    ref="ul"
    class="divide-y rounded-lg bg-white py-0 shadow"
  >
    <li v-for="(item, index) in store.items" :key="item.id" class="flex items-center px-6 py-3">
      <span class="cursor-grab">
        <Bars2Icon class="h-4 w-4 text-gray-500 hover:text-gray-800" />
      </span>
      <a href="#" class="group flex items-center ltr:ml-4 rtl:mr-4">
        <span
          class="block h-2 w-2 flex-shrink-0 rounded-full"
          :style="{ 'background-color': item.meta.color }"
        />
        <span class="truncate text-gray-500 group-hover:text-gray-900 ltr:ml-3 rtl:mr-3">
          {{ item.name }}
        </span>
      </a>
      <div class="ltr:ml-auto rtl:mr-auto">
        <ProjectUnarchive :id="item.id" :index="index" />
      </div>
    </li>
  </ul>
</template>

<script setup lang="ts">
  import { useProjectArchivedStore } from 'Store/project-archived'
  import { Bars2Icon } from '@heroicons/vue/24/outline'
  import NoData from './NoData.vue'
  import { Loader } from 'thetheme'
  import ProjectUnarchive from './ProjectUnarchive.vue'

  const store = useProjectArchivedStore()

  store.fetch()
</script>
