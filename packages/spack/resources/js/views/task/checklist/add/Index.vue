<template>
  <Form v-if="show" />

  <Button v-else />
</template>

<script setup lang="ts">
  import { useChecklistAddForm } from 'Use/checklist/add'
  import Form from './Form.vue'
  import Button from './Button.vue'

  const { close, show } = useChecklistAddForm()

  close()
</script>
