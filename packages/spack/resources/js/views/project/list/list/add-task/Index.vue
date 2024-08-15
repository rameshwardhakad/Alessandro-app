<template>
  <div :id="'add-task-wrapper-'+index" class="px-6 py-5">
    <Form v-if="isForm == index" :index="index" />
    <Button v-else :index="index" />
  </div>
</template>

<script setup lang="ts">
  import { useTaskAdd } from 'Use/project/task-add'
  import Form from './Form.vue'
  import Button from './Button.vue'

  const { isForm } = useTaskAdd('task-add-list')

  defineProps<{
    index: number
  }>()
</script>
