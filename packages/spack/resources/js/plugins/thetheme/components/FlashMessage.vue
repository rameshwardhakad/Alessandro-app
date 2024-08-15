<template>
  <Teleport to="body">
    <div
      v-if="flash.message"
      class="fixed flex h-10 items-center rounded px-4 text-sm text-white ltr:right-8 rtl:left-8"
      :class="{ 'bg-green-600': flash.type == 'success', 'bg-red-500': flash.type == 'danger' }"
      style="bottom: 7%; touch-action: pan-y; z-index: 2000"
    >
      {{ flash.message }}

      <XMarkIcon class="w-5 cursor-pointer ltr:ml-2 rtl:mr-2" @click="flash.hide" />
    </div>
  </Teleport>
</template>

<script setup lang="ts">
  import { useFlashStore } from 'spack'
  import { XMarkIcon } from '@heroicons/vue/24/outline'

  const flash = useFlashStore()
</script>
