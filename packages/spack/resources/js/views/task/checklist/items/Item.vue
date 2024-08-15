<template>
  <div
    class="group relative flex"
    :class="{ 'pointer-events-none': id == 0, 'opacity-75': id == 0 }"
  >
    <Checkbox :id="id" :index="index" :is-completed="isCompleted || null" />

    <p class="flex-1 cursor-text text-sm text-gray-700" @click="open(index, item)">
      {{ item }}
    </p>

    <Delete v-if="can('task:delete')" :id="id" :index="index" />
  </div>
</template>

<script setup lang="ts">
  import { useChecklistEditForm } from 'Use/checklist/edit'
  import Checkbox from './Checkbox.vue'
  import Delete from './Delete.vue'

  defineProps<{
    id: number
    index: number
    item: string
    isCompleted: string | null
  }>()

  const { open } = useChecklistEditForm()
</script>
