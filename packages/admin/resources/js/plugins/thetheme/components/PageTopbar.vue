<template>
  <div class="mb-4 flex">
    <h1 class="text-2xl font-semibold text-gray-900" data-cy="page-title">
      {{ __(title) }}
    </h1>

    <slot />

    <TheButton
      v-if="hasPermission && btnText"
      class="ltr:ml-auto rtl:mr-auto"
      data-cy="topbar-create-button"
      size="sm"
      @click="btnTo"
    >
      {{ __(btnText) }}
    </TheButton>
  </div>
</template>

<script setup lang="ts">
  import { can } from 'spack'
  import TheButton from './TheButton.vue'

  const { permission } = defineProps<{
    title: string
    btnTo?: (...args: any[]) => void
    btnText?: string
    permission?: string
  }>()

  const hasPermission = permission ? can(permission as string) : true
</script>
