<template>
  <div ref="listAddWrapper" :class="[getLists().length ? 'mt-6' : 'mt-2']">
    <ListAddForm v-if="isForm" />
    <ListAddButton v-else />
  </div>
</template>

<script setup lang="ts">
  import { useList } from 'Use/list'
  import { useListAdd } from 'Use/project/list-add'
  import ListAddButton from './Button.vue'
  import ListAddForm from './Form.vue'

  const { getLists } = useList()
  const { isForm, listAddWrapper } = useListAdd('list-add-list')
</script>
