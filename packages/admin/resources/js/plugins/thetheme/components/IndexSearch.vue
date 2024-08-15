<template>
  <div class="relative w-64 rounded-md shadow-sm">
    <div
      class="pointer-events-none absolute inset-y-0 flex items-center ltr:left-0 ltr:pl-3 rtl:right-0 rtl:pr-3"
    >
      <svg
        class="h-5 w-5 text-gray-400"
        x-description="Heroicon name: search"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20"
        fill="currentColor"
        aria-hidden="true"
      >
        <path
          fill-rule="evenodd"
          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
          clip-rule="evenodd"
        />
      </svg>
    </div>
    <input
      type="search"
      :placeholder="__('Search')"
      v-model="index.params.search"
      @input="index.onSearch"
      class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm ltr:pl-10 rtl:pr-10"
    />
  </div>
</template>

<script setup lang="ts">
  import { useIndexStore } from 'spack'

  const { name } = defineProps<{
    name: string
  }>()

  const index = useIndexStore(name)()
</script>
