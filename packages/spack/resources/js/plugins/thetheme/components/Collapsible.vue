<template>
  <div v-if="customTrigger">
    <slot name="trigger" :open="isOpen" :toggle="toggle" />
  </div>

  <div v-else @click.prevent="toggle">
    <slot name="trigger" :open="isOpen" :toggle="toggle" />
  </div>

  <slot v-if="isOpen" name="content" />
</template>

<script setup lang="ts">
  import { useLocalStorage } from '@vueuse/core'

  const props = defineProps<{
    name: string
    open?: boolean
    customTrigger?: boolean
  }>()

  const state = localStorage.getItem(`collapsible-${props.name}`)
  const isOpen = useLocalStorage(`collapsible-${props.name}`, false)

  if (state === null) {
    props.open && (isOpen.value = true)
  }

  function toggle() {
    isOpen.value = !isOpen.value
  }
</script>
