<template>
  <FieldBase :inline="inline" :label="label" :name="name" :lg="lg" :full="full">
    <div class="flex flex-wrap">
      <select
        :id="formName + '-' + name"
        v-model="form.data[name]"
        required
        :placeholder="placeholder"
        :class="{
          'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm': true,
          'border-gray-300': !form.errors[name],
          'border-red-600': form.errors[name],
          'sm:max-w-full': full,
          'sm:max-w-lg': lg,
          'max-w-lg sm:max-w-xs': inline,
        }"
      >
        <option :value="null" disabled>{{ __('Choose') + label }}</option>
        <option
          v-for="option in form.options[name]"
          :key="option[labelKey]"
          :value="option[valueKey]"
        >
          {{ option[labelKey] }}
        </option>
      </select>

      <slot />
    </div>
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
      placeholder?: string
      type?: 'text' | 'password' | 'number'
      disabled?: boolean
      full?: boolean
      inline?: boolean
      lg?: boolean
      labelKey?: string
      valueKey?: string
    }>(),
    {
      label: '',
      type: 'text',
      lg: false,
      disabled: false,
      placeholder: '',
      full: false,
      inline: false,
      labelKey: 'label',
      valueKey: 'value',
    },
  )
</script>
