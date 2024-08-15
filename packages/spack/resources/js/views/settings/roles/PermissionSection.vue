<template>
  <section class="mb-6 last:mb-0">
    <div class="mb-4 flex items-center border-b pb-2 text-sm">
      <p class="block text-sm font-medium text-gray-600">
        {{ section.name }}
      </p>

      <span
        class="block cursor-pointer text-xs text-gray-500 hover:text-gray-900 ltr:pl-4 rtl:pr-4"
        @click="select"
      >
        {{ __('Select All') }}
      </span>
      <span class="block px-1 text-xs text-gray-500">/</span>
      <span
        class="block cursor-pointer text-xs text-gray-500 hover:text-gray-900"
        @click="deselect"
      >
        {{ __('Deselect All') }}
      </span>
    </div>

    <div class="grid grid-cols-4 gap-3">
      <FieldCheckbox :options="section.options" />
    </div>
  </section>
</template>

<script setup lang="ts">
  import FieldCheckbox from './FieldCheckbox.vue'
  import { useFormStore } from 'spack'

  const form = useFormStore<any>('role')()

  const { section } = defineProps<{
    section: any
  }>()

  function select() {
    const sectionValues = section.options.map((x: any) => x.value)

    sectionValues.forEach((value: number) => {
      if (!form.data.permissions.includes(value)) {
        form.data.permissions.push(value)
      }
    })
  }

  function deselect() {
    console.log('on deselect section')
    const remove = section.options.map((x: any) => x.value)
    form.data.permissions = form.data.permissions.filter((item: number) => !remove.includes(item))
  }
</script>
