<template>
  <div class="mt-4 space-y-4">
    <template v-for="(item, index) in checklists.length ? checklists[0].items : []" :key="item.id">
      <Component
        :is="form == index ? EditForm : ChecklistItem"
        :id="item.id"
        :index="index"
        :item="item.name"
        :is-completed="item.completed_at || null"
      />
    </template>
  </div>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'
  import { useChecklistEditForm } from 'Use/checklist/edit'
  import ChecklistItem from './Item.vue'
  import EditForm from './EditForm.vue'

  const { checklists } = useTaskState()

  const { close, form } = useChecklistEditForm()

  close()
</script>
