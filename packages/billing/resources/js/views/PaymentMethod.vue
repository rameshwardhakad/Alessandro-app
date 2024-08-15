<template>
  <div class="mt-10">
    <h1 class="px-4 text-xl font-semibold text-gray-900 sm:px-8">
      {{ __('Payment Information') }}
    </h1>

    <div class="mt-3 sm:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="px-6 py-4">
          <p class="max-w-2xl text-sm text-gray-600">
            {{ __('Your current payment method is a credit card ending in') }}
            <span class="font-semibold">{{ cardLastFour }}</span>
          </p>

          <button
            @click="showCardInput"
            class="mt-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-indigo-500"
            v-if="!cardInput"
          >
            {{ __('Update Payment Information') }}
          </button>

          <div class="mt-6 rounded-md bg-red-50 p-4" v-show="errors.length">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg
                  class="h-5 w-5 text-red-400"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd"
                  />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                  {{ __('There are errors with your submission') }}
                </h3>
                <div class="mt-2 text-sm text-red-700">
                  <ul role="list" class="list-disc space-y-1 pl-5">
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 flex items-center" v-show="cardInput">
            <span class="mr-10 w-1/3 text-sm font-semibold text-gray-800">{{ __('Card') }}</span>
            <div id="card-element" class="w-full rounded border border-gray-200 p-3"></div>
          </div>
        </div>

        <div
          class="mt-5 border-t border-gray-100 bg-gray-100 bg-opacity-50 px-6 py-4 text-right"
          v-if="cardInput"
        >
          <button
            @click="hideCardInput"
            class="mr-2 inline-flex items-center px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-600 focus:outline-none focus:ring-indigo-500"
          >
            {{ __('Cancel') }}
          </button>

          <button
            @click="submit"
            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-indigo-500 disabled:opacity-75 disabled:hover:bg-indigo-600"
            :disabled="!cardInputIsComplete || processing"
          >
            {{ __('Update Payment Information') }}
            <v-loader class="ltr:ml-2 rtl:mr-2" size="16" color="text-white" v-if="processing" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { appData } from '@/app-data'
  import { ref } from 'vue'
  import VLoader from 'Component/Loader.vue'
  import { useBillingStore } from 'Store/billing'
  import { axios } from '@/util/axios'
  import {
    loadStripe,
    Stripe,
    StripeCardElement,
    StripeCardElementChangeEvent,
  } from '@stripe/stripe-js'

  const config = appData
  const errors = ref<string[]>([])
  const billing = useBillingStore()
  const processing = ref(false)
  const cardInput = ref(false)
  const cardInputIsComplete = ref(false)
  const cardInputLoaded = ref(false)
  const cardLastFour = ref(config.user.pm_last_four)
  const stripePromise = loadStripe(config.STRIPE_KEY)

  let stripe: Stripe | null = null
  let cardElement: StripeCardElement | null = null

  function showCardInput() {
    if (cardInputLoaded.value) {
      cardInput.value = true
      cardElement ? cardElement.clear() : console.error('cardElement is null')
    } else {
      createCardElement()
    }
  }

  function hideCardInput() {
    cardInput.value = false
    errors.value = []
  }

  async function createCardElement() {
    cardInputLoaded.value = false
    cardInputIsComplete.value = false
    cardInput.value = true

    stripe = await stripePromise
    const elements = stripe?.elements()

    if (elements) {
      cardElement = elements.create('card', {
        hidePostalCode: true,
      })
      cardElement.mount('#card-element')

      cardElement.on('ready', function () {
        cardInputLoaded.value = true
      })

      cardElement.on('change', (event: StripeCardElementChangeEvent) => {
        cardInputIsComplete.value = event.complete
        if (event.error) {
          errors.value = [event.error.message]
        } else {
          errors.value = []
        }
      })
    }
  }

  function submit() {
    processing.value = true
    errors.value = []

    confirmCard()
  }

  async function confirmCard() {
    if (!stripe || !cardElement) {
      errors.value.push('Stripe or card element is not initialized.')
      return
    }

    try {
      const result = await stripe.confirmCardSetup(config.client_secret as string, {
        payment_method: {
          card: cardElement as StripeCardElement,
        },
      })

      if (result.error) {
        // Display "error.message" to the user...
        console.log('card error')
        processing.value = false
        errors.value.push(result.error.message as string)
      } else if (result.setupIntent) {
        // The card has been verified successfully...
        console.log('success')
        console.log(result.setupIntent)
        console.log(result.setupIntent.payment_method)

        updatePaymentMethod(result.setupIntent.payment_method as string)
      }
    } catch (error) {
      processing.value = false
      if (error instanceof Error) {
        errors.value.push(error.message)
      } else {
        errors.value.push('An unknown error occurred.')
      }
      console.error(error)
    }
  }

  function updatePaymentMethod(paymentMethodId: string | null = null) {
    axios
      .post('payment-method', {
        paymentMethodId,
      })
      .then(({ data }) => {
        console.log('data')
        console.log(data)

        if (data.success) {
          cardInput.value = false
          cardLastFour.value = data.pm_last_four
          billing.cardLastFour = data.pm_last_four
        }

        if (data.error) {
          errors.value.push(data.error)
        }

        processing.value = false
      })
      .catch(() => {
        processing.value = false
      })
  }
</script>
