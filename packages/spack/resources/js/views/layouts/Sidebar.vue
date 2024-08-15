<template>
  <aside
    id="sidebar"
    :class="[!store.showSidebar && 'ltr:-translate-x-full rtl:translate-x-full']"
    class="fixed inset-y-0 z-40 grid w-64 transform grid-rows-[auto,1fr] bg-gray-800 transition-transform duration-300"
  >
    <SidebarLogo />

    <div class="custom-scrollbar">
      <SidebarNav />
      <SidebarProjects />
    </div>
  </aside>
</template>

<script setup lang="ts">
  import SidebarLogo from './SidebarLogo.vue'
  import SidebarNav from './SidebarNav.vue'
  import SidebarProjects from './projects/Index.vue'
  import { useStore } from 'Store/main'

  const store = useStore()
</script>

<style scoped>
  .custom-scrollbar::-webkit-scrollbar {
    width: 0;
  }

  .custom-scrollbar:hover::-webkit-scrollbar {
    width: 10px;
  }

  .custom-scrollbar::-webkit-scrollbar-track {
    background-color: transparent;
  }

  .custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #6b7280;
  }

  .custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: transparent transparent;
  }

  .custom-scrollbar:hover {
    scrollbar-color: #6b7280 transparent;
    overflow-y: auto;
  }
</style>
