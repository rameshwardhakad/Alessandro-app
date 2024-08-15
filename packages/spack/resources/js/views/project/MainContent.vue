<template>
  <div class="page-container h-full">
    <section class="grid h-full grid-rows-[auto_1fr] gap-4">
      <header class="flex items-center">
        <Color v-if="can('project:update')" />
        <ColorDisplayOnly v-else />
        <Name v-if="can('project:update')" />
        <NameDisplayOnly v-else />
        <TabNav />
        <Members />
        <!-- <Filters class="ml-auto"/> -->
        <!-- <Menu class="ml-auto"/> -->
      </header>

      <main class="relative">
        <Component :is="tabStore.tab" />
      </main>
    </section>
  </div>
</template>

<script setup lang="ts">
  import { useTabStore } from 'spack'
  import Color from './Color.vue'
  import ColorDisplayOnly from './ColorDisplayOnly.vue'
  import Name from './Name.vue'
  import NameDisplayOnly from './NameDisplayOnly.vue'
  import Members from './members/Index.vue'
  // import Menu from './Menu.vue'
  // import Filters from './Filters.vue'
  import TabNav from './TabNav.vue'
  import TabBoard from './board/Index.vue'
  import TabList from './list/Index.vue'

  const tabStore = useTabStore()()

  tabStore.tabs([TabBoard, TabList])
</script>
