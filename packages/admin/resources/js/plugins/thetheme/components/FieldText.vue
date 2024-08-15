<template>
  <FieldBase :inline="inline" :label="label" :name="name" :lg="lg" :full="full" :info="info">
    <input
      :id="formName + '-' + name"
      v-model="form.data[name]"
      :type="type"
      :placeholder="label"
      :disabled="disabled"
      :class="{
        'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm': true,
        'border-gray-300': !form.errors[name],
        'border-red-600': form.errors[name],
        'sm:max-w-full': full,
        'sm:max-w-lg': lg,
        'max-w-lg sm:max-w-xs': inline,
      }"
    />
  </FieldBase>
</template>

<script setup lang="ts" generic="T">
  import { inject } from 'vue'
  import { useFormStore } from 'spack'
  import FieldBase from './FieldBase.vue'

  const formName = inject('form_name', '')
  const form = useFormStore<any>(formName)()

  withDefaults(
    defineProps<{
      name: string
      label: string
      type?: 'text' | 'password' | 'number'
      disabled?: boolean
      full?: boolean
      inline?: boolean
      lg?: boolean
      info?: string
    }>(),
    {
      label: '',
      type: 'text',
      lg: false,
      disabled: false,
      full: false,
      inline: false,
      info: '',
    },
  )
</script>
