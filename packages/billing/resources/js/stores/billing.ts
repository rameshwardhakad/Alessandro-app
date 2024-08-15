import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useBillingStore = defineStore('billing', () => {
  const cardLastFour = ref<string | null>(null)
  const isSubscribed = ref<Subscription | null>(null)
  const onGracePeriod = ref<boolean>(false)
  const subscribePlan = ref<string | null>(null)

  return {
    cardLastFour,
    isSubscribed,
    onGracePeriod,
    subscribePlan,
  }
})
