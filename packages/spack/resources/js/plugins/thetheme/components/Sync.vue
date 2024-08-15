<template>
  <div v-if="isOffline" class="flex items-center">
    <WifiIcon class="h-4 w-4 text-gray-400" />
    <span class="text-sm text-red-500 ltr:ml-2 rtl:mr-2">{{ __('Offline') }}</span>
  </div>

  <div v-if="false" class="flex items-center">
    <ArrowPathIcon class="h-4 w-4 text-gray-400" />
    <span class="text-sm text-blue-500 ltr:ml-2 rtl:mr-2">{{ __('Sync') }}</span>
  </div>

  <div v-if="false" class="flex items-center">
    <ArrowPathIcon class="h-4 w-4 animate-spin text-gray-400" />
    <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">{{ __('Syncing...') }}</span>
  </div>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { useQueue } from 'spack'
  import { ArrowPathIcon, WifiIcon } from '@heroicons/vue/24/solid'

  const { processQueue } = useQueue()
  const isOffline = ref(false)

  processQueue()

  window.addEventListener('offline', () => {
    isOffline.value = true
  })

  window.addEventListener('online', () => {
    isOffline.value = false
  })
</script>
