<template>
  <div
    ref="listWrapper"
    class="absolute inset-0 select-none overflow-x-auto overflow-y-hidden whitespace-nowrap text-[0] transition-opacity"
  >
    <List
      v-for="(list, index) in getLists()"
      :key="`list-${list.id}`"
      :index="index"
      :list="list"
    />

    <ListAdd v-if="can('project-list:create')" />
  </div>
</template>

<script setup lang="ts">
  import { onMounted } from 'vue'
  import { useList } from 'Use/list'
  import List from './list/Index.vue'
  import ListAdd from './list-add/Index.vue'

  const { getLists, listsSortable, listWrapper } = useList()

  onMounted(() => listsSortable())
</script>
