<template>
  <FieldBase :inline="inline" :label="label" :name="name" :lg="lg" :full="full">
    <div class="flex items-center pt-2">
      <input
        :id="formName + '-' + name"
        v-model="form.data[name]"
        type="checkbox"
        :value="form.options[name][0].value"
        :placeholder="label"
        :disabled="disabled"
        class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
      />

      <label
        :for="formName + '-' + name"
        class="ltr:ml-3 rtl:mr-3 block whitespace-nowrap text-sm font-medium text-gray-700"
      >
        {{ form.options[name][0].label }}
      </label>
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
      type?: 'text' | 'password' | 'number'
      disabled?: boolean
      full?: boolean
      inline?: boolean
      lg?: boolean
    }>(),
    {
      label: '',
      type: 'text',
      lg: false,
      disabled: false,
      full: false,
      inline: false,
    },
  )
</script>
