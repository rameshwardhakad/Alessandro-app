<template>
  <div>
    <h1 class="px-4 text-xl font-semibold text-gray-900 sm:px-8">
      {{ __('Resume Subscription') }}
    </h1>

    <div class="mt-3 sm:px-8">
      <div class="bg-white px-6 py-4 shadow-sm sm:rounded-lg">
        <div class="max-w-2xl text-sm leading-6 text-gray-600">
          Having second thoughts about cancelling your subscription? You can instantly reactive your
          subscription at any time until the end of your current billing cycle. After your current
          billing cycle ends, you may choose an entirely new subscription plan.
        </div>
        <div class="mt-4">
          <button
            @click="resume"
            class="ml-auto inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-indigo-500 disabled:opacity-75 disabled:hover:bg-indigo-600"
            :disabled="processing"
          >
            {{ __('Resume Subscription') }}
            <v-loader class="ltr:ml-2 rtl:mr-2" color="text-white" v-if="processing" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { axios } from '@/util/axios'
  import { useBillingStore } from 'Store/billing'
  import VLoader from 'Component/Loader.vue'

  const processing = ref(false)
  const billing = useBillingStore()

  function resume() {
    if (confirm('Are you sure you want to resume your subscription!')) {
      processing.value = true

      axios
        .post('subscription/resume')
        .then((data) => {
          console.log('data')
          console.log(data)
          processing.value = false
          billing.onGracePeriod = false
        })
        .catch(() => {
          processing.value = false
        })
    }
  }
</script>
