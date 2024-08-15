<template>
  <div id="sideBar" class="hidden w-96 bg-white px-6 pt-24 shadow-lg lg:block">
    <h1 class="text-3xl font-bold text-gray-900">
      {{ config.app_name }}
    </h1>
    <h2 class="mt-1 text-lg font-semibold text-gray-700">
      {{ __('Billing Management') }}
    </h2>

    <div class="mt-12 flex items-center text-gray-600">
      <div>{{ __('Signed in as') }}</div>
      <UserAvatar :avatar="config.user.avatar" class="ml-2 h-6 w-6" />
      <div class="ml-2">{{ config.user.name }}.</div>
    </div>

    <div class="mt-3 text-sm text-gray-600">
      {{ __('Managing billing for') }} {{ config.user.name }}.
    </div>

    <form
      method="POST"
      action="/logout"
      class="mt-12"
      v-if="billing.subscribePlan === null && !billing.isSubscribed"
    >
      <input type="hidden" name="_token" :value="config.csrf_token" />

      <a
        href="/logout"
        onclick="event.preventDefault(); this.closest('form').submit();"
        class="flex items-center"
      >
        <svg
          class="h-5 w-5 text-gray-400"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
          />
        </svg>

        <div class="ml-2 text-gray-600 underline">{{ __('Logout') }}</div>
      </a>
    </form>

    <div id="sideBarReturnLink" class="mt-12" v-else>
      <a href="/app" class="flex items-center">
        <svg viewBox="0 0 20 20" fill="currentColor" class="arrow-left h-5 w-5 text-gray-400">
          <path
            fill-rule="evenodd"
            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
            clip-rule="evenodd"
          />
        </svg>

        <div class="ml-2 text-gray-600 underline">{{ __('Return to') }} {{ config.app_name }}</div>
      </a>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { appData } from '@/app-data'
  import { useBillingStore } from 'Store/billing'
  import UserAvatar from 'Component/UserAvatar.vue'

  const config = appData
  const billing = useBillingStore()
</script>
