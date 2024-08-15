<template>
  <h2 class="rounded px-2 text-xl/7 font-medium text-gray-800">
    {{ project.name }}
  </h2>
</template>

<script setup lang="ts">
  import { useProjectDetailStore } from 'Store/project-detail'

  const { project } = useProjectDetailStore()
</script>
