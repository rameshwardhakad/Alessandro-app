<template>
  <ModalBase>
    <div v-if="store.fetching" class="page-loader py-40">
      <Loader color="text-gray-400" />
    </div>

    <Design1 v-else />
  </ModalBase>
</template>

<script setup lang="ts">
  import { useProjectMemberStore } from 'Store/project-member'
  import { Loader, ModalBase } from 'thetheme'
  import Design1 from './Design1.vue'

  const store = useProjectMemberStore()

  store.fetch()
</script>
