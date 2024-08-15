<template>
  <section class="py-3">
    <h2 class="px-2 text-sm font-medium text-gray-600">
      {{ __('Project List') }}
    </h2>

    <Readonly v-if="cannot('task:update')" />

    <ListDropdown v-else />
  </section>
</template>

<script setup lang="ts">
  import ListDropdown from './ListDropdown.vue'
  import Readonly from './Readonly.vue'
</script>
