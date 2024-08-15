<template>
  <div class="min-h-screen bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
      <LayoutSidebar />

      <LayoutMain />
    </div>
  </div>
</template>

<script setup lang="ts">
  import LayoutMain from 'View/Main.vue'
  import LayoutSidebar from 'View/Sidebar.vue'
</script>
