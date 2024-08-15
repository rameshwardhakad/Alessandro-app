<template>
  <div class="space-y-6">
    <List
      v-for="(list, index) in getLists()"
      :key="`list-${list.id}`"
      :index="index"
      :list="list"
    />
  </div>

  <AddList v-if="can('project-list:create')" />

  <div class="h-14">&nbsp;</div>
</template>

<script setup lang="ts">
  import { useList } from 'Use/list'
  import List from './list/Index.vue'
  import AddList from './list-add/Index.vue'

  const { getLists } = useList()
</script>
