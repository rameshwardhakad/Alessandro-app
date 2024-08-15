<template>
  <div
    ref="listAddWrapper"
    class="box-border inline-block h-full w-72 whitespace-nowrap rounded-xl pb-4 align-top text-base"
  >
    <ListAddForm v-if="isForm" />
    <ListAddButton v-else />
  </div>
</template>

<script setup lang="ts">
  import { useListAdd } from 'Use/list-add'
  import ListAddButton from './Button.vue'
  import ListAddForm from './Form.vue'

  const { isForm, listAddWrapper } = useListAdd()
</script>
