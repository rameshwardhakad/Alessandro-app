<template>
  <ModalBase stop-hide>
    <FormModalSkeleton v-if="form.fetching" />

    <section v-else>
      <div class="flex items-center px-6 pt-6">
        <h1 class="text-xl font-semibold text-gray-900" data-cy="page-title">
          {{ title || (id ? __(`Edit ${getTitle}`) : __(`Create ${getTitle}`)) }}
        </h1>
        <span
          class="block h-7 w-7 cursor-pointer rounded-md p-0.5 hover:bg-gray-100 ltr:ml-auto rtl:mr-auto"
          @click="useModalsStore().pop()"
        >
          <XMarkIcon class="text-gray-400" />
        </span>
      </div>

      <div class="px-6">
        <div class="grid grid-cols-12 gap-6 pb-6 pt-3">
          <slot />
        </div>
      </div>

      <div class="bottom-0 flex justify-end rounded-b-lg bg-gray-50 px-6 py-5">
        <TheButton
          size="sm"
          class="ltr:mr-3 rtl:ml-3"
          white
          :disabled="form.submitting"
          @click="useModalsStore().pop()"
        >
          {{ __('Cancel') }}
        </TheButton>

        <TheButton
          size="sm"
          data-cy="submit-button"
          :processing="form.submitting"
          @click="form.submit"
        >
          {{ id ? __(`Update ${getTitle}`) : __(`Create ${getTitle}`) }}
        </TheButton>
      </div>
    </section>
  </ModalBase>
</template>

<script setup lang="ts">
  import ModalBase from './ModalBase.vue'
  import FormModalSkeleton from './FormModalSkeleton.vue'
  import TheButton from './TheButton.vue'
  import { useFormStore, useModalsStore } from 'spack'
  import { computed, provide } from 'vue'
  import { XMarkIcon } from '@heroicons/vue/24/outline'

  const props = defineProps<{
    id?: number
    name: string
    uri: string
    title?: string
  }>()

  const getTitle = computed(() => {
    const arr = props.name.split('-')

    for (let i = 0; i < arr.length; i++) {
      arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1)
    }

    return arr.join(' ')
  })

  provide('form_name', props.name)

  const form = useFormStore(props.name)()

  form.init(props.uri, props.id)
</script>
