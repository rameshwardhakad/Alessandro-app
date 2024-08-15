<template>
  <div class="mt-10">
    <h1 class="px-4 text-xl font-semibold text-gray-900 sm:px-8">
      {{ __('Cancel Subscription') }}
    </h1>

    <div class="mt-3 sm:px-8">
      <div class="bg-white px-6 py-4 shadow-sm sm:rounded-lg">
        <div class="max-w-2xl text-sm text-gray-600">
          You may cancel your subscription at any time. Once your subscription has been cancelled,
          you will have the option to resume the subscription until the end of your current billing
          cycle.
        </div>
        <div class="mt-4">
          <button
            @click="cancel"
            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:text-gray-500 focus:outline-none focus:ring active:bg-gray-50 active:text-gray-800"
          >
            {{ __('Cancel Subscription') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { axios } from '@/util/axios'

  const processing = ref(false)

  function cancel() {
    if (confirm('Are you sure you want to cancel your subscription!')) {
      axios
        .post('subscription/cancel')
        .then((data) => {
          console.log('data')
          console.log(data)
          processing.value = false
        })
        .catch(() => {
          processing.value = false
        })
    }
  }
</script>
