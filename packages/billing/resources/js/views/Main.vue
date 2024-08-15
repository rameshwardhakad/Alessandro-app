<template>
  <div class="flex-1">
    <LayoutHeaderMobile />

    <div class="pb-6 pt-6 lg:mx-auto lg:max-w-4xl lg:pb-24 lg:pt-24">
      <div
        v-show="billing.isSubscribed && billing.subscribePlan === null && !billing.onGracePeriod"
      >
        <h1 class="px-4 text-xl font-semibold text-gray-900 sm:px-8">{{ __('Subscription') }}</h1>
      </div>

      <SubscribePlan v-if="billing.subscribePlan !== null" />

      <NoSubscriptionMessage v-if="billing.subscribePlan === null && !billing.isSubscribed" />
      <SubscriptionPlans v-if="billing.subscribePlan === null && !billing.onGracePeriod" />
      <PaymentMethod
        v-if="billing.subscribePlan === null && billing.isSubscribed && !billing.onGracePeriod"
      />
      <SubscriptionCancel
        v-if="billing.subscribePlan === null && billing.isSubscribed && !billing.onGracePeriod"
      />
      <SubscriptionResume v-if="billing.subscribePlan === null && billing.onGracePeriod" />
      <SubscriptionReceipts v-if="billing.subscribePlan === null && invoices.length" />
    </div>
  </div>
</template>

<script setup lang="ts">
  import { appData } from '@/app-data'
  import { useBillingStore } from 'Store/billing'
  import LayoutHeaderMobile from './HeaderMobile.vue'
  import SubscribePlan from './SubscribePlan.vue'
  import NoSubscriptionMessage from './NoSubscriptionMessage.vue'
  import SubscriptionPlans from './SubscriptionPlans.vue'
  import PaymentMethod from './PaymentMethod.vue'
  import SubscriptionCancel from './SubscriptionCancel.vue'
  import SubscriptionResume from './SubscriptionResume.vue'
  import SubscriptionReceipts from './SubscriptionReceipts.vue'

  const billing = useBillingStore()
  const invoices = appData.invoices

  billing.subscribePlan = appData.subscribePlan
  billing.isSubscribed = appData.isSubscribed
  billing.onGracePeriod = appData.onGracePeriod
  billing.cardLastFour = appData.cardLastFour
</script>
