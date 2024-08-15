<template>
  <svg
    class="animate-spin stroke-current"
    :class="color"
    viewBox="0 0 32 32"
    :width="size"
    :height="size"
  >
    <circle cx="16" cy="16" fill="none" r="14" :stroke-width="thick" style="opacity: 0.2" />
    <circle
      cx="16"
      cy="16"
      fill="none"
      r="14"
      :stroke-width="thick"
      style="stroke-dasharray: 80; stroke-dashoffset: 60"
    />
  </svg>
</template>

<script setup lang="ts">
  interface Props {
    size?: string
    color?: string
    thick?: string
  }

  withDefaults(defineProps<Props>(), {
    color: 'text-gray-800',
    size: '40',
    thick: '4',
  })
</script>
