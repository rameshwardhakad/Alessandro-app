<template>
  <div class="mt-6 space-y-6 sm:px-8">
    <div
      class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
      v-for="plan in config.plans"
      :key="plan.id"
    >
      <div>
        <div class="flex justify-between">
          <h2 class="px-6 pt-4 text-xl font-semibold text-gray-700">{{ plan.name }}</h2>
        </div>
        <div class="px-6 pb-4">
          <div class="text-md mt-2 font-semibold text-gray-700">
            <span>${{ plan.meta.monthly_price }}</span> / {{ __('monthly') }}
            <span class="font-medium text-gray-400">
              ({{ config.trial_days }} {{ __('day trial') }})
            </span>
          </div>
          <div class="mt-3 max-w-xl text-sm text-gray-600">
            {{ plan.meta.short_description }}
          </div>
          <div class="mt-3 space-y-2">
            <div class="flex items-center" v-for="feature in plan.meta.features" :key="feature">
              <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-green-400">
                <path
                  fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"
                />
              </svg>
              <div class="ml-2 text-sm text-gray-600">{{ feature }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="border-t border-gray-100 bg-gray-100 bg-opacity-50 px-6 py-4 text-right">
        <div class="ml-1 text-sm text-gray-400" v-show="billing.isSubscribed?.type == plan.name">
          {{ __('Currently Subscribed') }}
        </div>

        <button
          @click="subscribe(plan.name)"
          v-show="billing.isSubscribed?.type != plan.name"
          class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-indigo-500"
        >
          {{ __('Subscribe') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { appData } from '@/app-data'
  import { useBillingStore } from 'Store/billing'

  const config = appData
  const billing = useBillingStore()

  window.onpopstate = function () {
    if (window.location.pathname == '/billing' && !window.location.search) {
      billing.subscribePlan = null
    }
  }

  function subscribe(plan: string) {
    const url = new URL(window.location.href)
    url.searchParams.set('subscribe', plan)
    window.history.pushState({}, '', url)

    billing.subscribePlan = plan
  }
</script>
