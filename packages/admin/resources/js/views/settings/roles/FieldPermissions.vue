<template>
  <div class="col-span-12">
    <div class="flex items-center text-sm">
      <p class="block text-sm font-medium text-gray-800">
        {{ __('Permissions') }}
      </p>
      <span
        class="block cursor-pointer text-xs text-gray-600 hover:text-gray-900 ltr:pl-4 rtl:pr-4"
        @click="select"
      >
        {{ __('Select All') }}
      </span>
      <span class="block px-1 text-xs text-gray-600">/</span>
      <span
        class="block cursor-pointer text-xs text-gray-600 hover:text-gray-900"
        @click="deselect"
      >
        {{ __('Deselect All') }}
      </span>
    </div>

    <p class="mb-6 mt-2 text-xs italic text-gray-500">
      {{ __('You may select any permissions for this specific role.') }}
    </p>

    <PermissionSection v-for="section in sections" :key="section.name" :section="section" />
  </div>
</template>

<script setup lang="ts">
  import { computed } from 'vue'
  import { useFormStore } from 'spack'
  import PermissionSection from './PermissionSection.vue'

  const form = useFormStore<any>('role')()

  function select() {
    form.data.permissions = form.options.permissions.map((x: any) => x.value)
  }

  function deselect() {
    form.data.permissions = []
  }

  const sections = computed(() => {
    return form.options.permissions.reduce((acc: any, { label, value }: any) => {
      const [category, action] = label.split(':')
      const formattedCategory = category
        .replace(/-/g, ' ')
        .replace(/\b\w/g, (c: any) => c.toUpperCase())
      const formattedAction = action
        ? action.replace(/-/g, ' ').replace(/\b\w/g, (c: any) => c.toUpperCase())
        : formattedCategory

      const existingCategory = acc.find((c: any) => c.name === formattedCategory)

      if (existingCategory) {
        existingCategory.options.push({ label: formattedAction, value })
      } else {
        acc.push({
          name: formattedCategory,
          options: [{ label: formattedAction, value }],
        })
      }

      return acc
    }, [])
  })
</script>
