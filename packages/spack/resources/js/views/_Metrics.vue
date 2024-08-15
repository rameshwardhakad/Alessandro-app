<template>
  <section>
    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:py-6">
        <dt>
          <div class="absolute rounded-md bg-indigo-500 p-3">
            <InboxIcon class="h-6 w-6 text-white" />
          </div>
          <p class="truncate text-sm font-medium text-gray-500 ltr:ml-16 rtl:mr-16">
            {{ __('Open Tasks') }}
          </p>
        </dt>
        <dd class="flex items-baseline ltr:ml-16 rtl:mr-16">
          <p class="text-2xl font-semibold text-gray-900">
            {{ metrics.open_tasks }}
          </p>
        </dd>
      </div>

      <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:py-6">
        <dt>
          <div class="absolute rounded-md bg-indigo-500 p-3">
            <FolderIcon class="h-6 w-6 text-white" />
          </div>
          <p class="truncate text-sm font-medium text-gray-500 ltr:ml-16 rtl:mr-16">
            {{ __('Completed Tasks') }}
          </p>
        </dt>
        <dd class="flex items-baseline ltr:ml-16 rtl:mr-16">
          <p class="text-2xl font-semibold text-gray-900">
            {{ metrics.completed_tasks }}
          </p>
        </dd>
      </div>

      <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:py-6">
        <dt>
          <div class="absolute rounded-md bg-indigo-500 p-3">
            <FolderIcon class="h-6 w-6 text-white" />
          </div>
          <p class="truncate text-sm font-medium text-gray-500 ltr:ml-16 rtl:mr-16">
            {{ __('Total Projects') }}
          </p>
        </dt>
        <dd class="flex items-baseline ltr:ml-16 rtl:mr-16">
          <p class="text-2xl font-semibold text-gray-900">
            {{ metrics.total_projects }}
          </p>
        </dd>
      </div>
    </dl>
  </section>
</template>

<script setup lang="ts">
  import { useHome } from 'Use/home'
  import { FolderIcon, InboxIcon } from '@heroicons/vue/24/outline'

  const { metrics } = useHome()
</script>
