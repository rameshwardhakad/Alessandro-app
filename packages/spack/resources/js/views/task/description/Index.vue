<template>
  <div class="mt-4 flex items-start">
    <Bars3BottomLeftIcon class="h-4 w-4 text-gray-500 ltr:mr-4 rtl:ml-4" />

    <div class="flex-1">
      <Content v-if="!isForm && task.description" />
      <Skelton v-if="!isForm && !task.description" />
      <Form v-if="isForm" />
    </div>
  </div>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'
  import { useTaskDescriptionForm } from 'Use/task/descriptionForm'
  import { Bars3BottomLeftIcon } from '@heroicons/vue/24/outline'
  import Skelton from './Skelton.vue'
  import Form from './Form.vue'
  import Content from './Content.vue'

  const { task } = useTaskState()
  const { init, isForm } = useTaskDescriptionForm()

  init()
</script>
