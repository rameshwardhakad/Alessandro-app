<template>
  <div class="h-7 w-7 rounded p-[0.563rem]">
    <p class="h-2.5 w-2.5 rounded-full" :style="{ 'background-color': project.meta.color }">
      &nbsp;
    </p>
  </div>
</template>

<script setup lang="ts">
  import { useProjectDetailStore } from 'Store/project-detail'

  const { project } = useProjectDetailStore()
</script>
