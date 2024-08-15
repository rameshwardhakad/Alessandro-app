<template>
  <div>
    <h1 class="px-4 text-xl font-semibold text-gray-900 sm:px-8">{{ __('Subscribe') }}</h1>
    <div class="mt-6 sm:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
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
      </div>

      <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="px-6 py-4">
          <h2 class="text-xl font-semibold text-gray-700">{{ __('Subscription Information') }}</h2>

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

          <div class="mt-6 flex items-center">
            <span class="mr-10 w-1/3 text-sm font-semibold text-gray-800">{{ __('Card') }}</span>

            <div class="w-full" v-if="!cardInput && config.user.pm_last_four">
              <div
                class="flex w-full items-center rounded border border-gray-200 bg-white p-3 text-sm text-gray-500"
              >
                <p class="flex-1">
                  {{ __('Card') }} <span class="font-semibold">{{ billing.cardLastFour }}</span
                  >.
                </p>

                <div class="flex-shrink-0">
                  <svg
                    class="h-5 w-5 text-green-400"
                    x-description="Heroicon name: solid/check-circle"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
              </div>

              <p
                class="ml-px mt-1.5 cursor-pointer text-xs font-medium text-gray-500 hover:underline"
                @click="updateCard"
              >
                {{ __('Update Card') }}
              </p>
            </div>

            <div
              class="w-full animate-pulse rounded bg-gray-200 p-2"
              v-if="cardInput && !cardInputLoaded"
            >
              &nbsp;
            </div>

            <div class="w-full" v-show="cardInput && cardInputLoaded">
              <div
                id="card-element"
                class="w-full rounded border border-gray-200 bg-white p-3"
                v-show="cardInput && cardInputLoaded"
              ></div>
              <p
                class="ml-px mt-1.5 cursor-pointer text-xs font-medium text-gray-500 hover:underline"
                @click="usePreviousCard"
                v-show="cardInput && config.user.pm_last_four"
              >
                {{ __('Use previous card') }}
              </p>
            </div>
          </div>
        </div>

        <div
          class="mt-5 flex items-center border-t border-gray-100 bg-gray-100 bg-opacity-50 px-6 py-4"
        >
          <div>
            <span>{{ __('Total') }}: ${{ plan.meta.monthly_price }}</span>
          </div>

          <button
            @click="submit"
            class="ml-auto inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-indigo-500 disabled:opacity-75 disabled:hover:bg-indigo-600"
            :disabled="!cardInputIsComplete || processing"
          >
            {{ __('Subscribe') }}
            <VLoader class="ltr:ml-2 rtl:mr-2" size="16" color="text-white" v-if="processing" />
          </button>
        </div>
      </div>
    </div>

    <button @click="choosePlan" class="mt-4 flex items-center px-4 sm:px-8">
      <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-gray-400">
        <path
          fill-rule="evenodd"
          d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
          clip-rule="evenodd"
        />
      </svg>
      <div class="ml-2 text-sm text-gray-600 underline">{{ __('Select a different plan') }}</div>
    </button>
  </div>
</template>

<script setup lang="ts">
  import { appData } from '@/app-data'
  import { ref, onMounted } from 'vue'
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
  const plan = config.plans.find((x) => x.name == billing.subscribePlan) as Plan
  const stripePromise = loadStripe(config.STRIPE_KEY)
  let stripe: Stripe | null = null
  let cardElement: StripeCardElement | null = null

  if (!plan) {
    window.location.replace('/billing')
  }

  onMounted(function () {
    if (config.user.pm_last_four) {
      cardInputIsComplete.value = true
      return
    }

    createCardElement()
  })

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

  function updateCard() {
    if (cardInputLoaded.value) {
      cardInput.value = true

      cardElement ? cardElement.clear() : console.error('cardElement is null')
    } else {
      createCardElement()
    }
  }

  function usePreviousCard() {
    cardInput.value = false
  }

  function choosePlan() {
    const url = new URL(window.location.href)
    window.history.pushState({}, '', url.href.split('?')[0])

    billing.subscribePlan = null
  }

  function submit() {
    processing.value = true
    errors.value = []

    if (cardInput.value) {
      confirmCard()
    } else {
      subscribe()
    }
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

        subscribe(result.setupIntent.payment_method as string)
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

  function subscribe(paymentMethodId: string | null = null) {
    axios
      .post('subscription', {
        paymentMethodId,
        plan: billing.subscribePlan,
      })
      .then((response) => {
        console.log('data!!')
        console.log(response.data)

        if (response.data.success) {
          billing.isSubscribed = { type: billing.subscribePlan as string }
          billing.subscribePlan = null
        }

        if (response.data.payment_id) {
          errors.value.push(response.data.error)
          window.location.href = '/stripe/payment/' + response.data.payment_id + '?redirect=%2Fapp'
          return
        }

        if (response.data.error) {
          errors.value.push(response.data.error)
        }

        processing.value = false
      })
      .catch(() => {
        processing.value = false
      })
  }
</script>
