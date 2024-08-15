<template>
  <div v-for="option in options" :key="option.value" class="flex items-center">
    <input
      :id="'permission-' + option.value"
      v-model="form.data.permissions"
      type="checkbox"
      class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
      :value="option.value"
    />

    <label
      :for="'permission-' + option.value"
      class="block whitespace-nowrap text-xs text-gray-600 ltr:ml-3 rtl:mr-3"
    >
      {{ option.label }}
    </label>
  </div>
</template>

<script setup lang="ts">
  import { useFormStore } from 'spack'

  const name = 'role'
  const form = useFormStore<any>(name)()

  defineProps<{
    options: { label: string; value: string }[]
  }>()
</script>
