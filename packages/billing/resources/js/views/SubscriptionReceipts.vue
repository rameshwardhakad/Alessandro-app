<template>
  <div class="mt-10">
    <h1 class="px-4 text-xl font-semibold text-gray-900 sm:px-8">{{ __('Receipts') }}</h1>

    <div class="mt-3 sm:px-8">
      <div class="divide-y divide-gray-100 bg-white shadow-sm sm:rounded-lg">
        <div class="flex items-center px-6 py-4" v-for="invoice in invoices" :key="invoice.id">
          <div class="w-40 text-sm">{{ invoice.date }}</div>
          <div class="ml-10 w-40 text-sm">
            <span>{{ invoice.total }}</span>
          </div>
          <div class="ml-10">
            <a
              :href="'/billing/api/user/invoice/' + invoice.id"
              target="_blank"
              class="text-sm text-gray-500 underline"
            >
              {{ __('Download Receipt') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { appData } from '@/app-data'

  const invoices = appData.invoices
</script>
