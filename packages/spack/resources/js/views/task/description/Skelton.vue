<template>
  <div class="cursor-text text-sm leading-none text-gray-500" @click="showForm">
    {{ __('Description') }}
  </div>
</template>

<script setup lang="ts">
  import { useTaskDescriptionForm } from 'Use/task/descriptionForm'

  const { showForm } = useTaskDescriptionForm()
</script>
