<template>
  <div v-if="errors.length">
    <div class="h-6">&nbsp;</div>

    <div class="rounded-md bg-red-50 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <XCircleIcon class="h-[1.375rem] w-[1.375rem] text-red-400" />
        </div>
        <div class="ltr:ml-3 rtl:mr-3">
          <h3 class="text-sm font-medium text-red-800">Oops!</h3>
          <div class="mt-2 text-sm text-red-700">
            <ul class="list-disc space-y-1 ltr:pl-5 rtl:pr-5">
              <li v-for="error in errors" :key="error">{{ error }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { useErrors } from 'Use/errors'
  import { XCircleIcon } from '@heroicons/vue/24/solid'

  const { errors } = useErrors()
</script>
