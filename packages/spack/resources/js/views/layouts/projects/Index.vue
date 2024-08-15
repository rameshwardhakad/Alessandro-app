<template>
  <section class="mt-6 px-2">
    <Collapsible name="sidebar-projects" open>
      <template #trigger="{ open }">
        <div class="flex cursor-pointer items-center ltr:pl-3 rtl:pr-3">
          <ChevronDownIcon
            class="h-4 w-4 text-gray-500"
            :class="{ 'ltr:rotate-[270deg] rtl:rotate-[90deg]': !open }"
          />

          <h3 class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
            {{ __('Projects') }}
          </h3>

          <div class="flex items-center ltr:ml-auto rtl:mr-auto">
            <RouterLink v-slot="{ href, navigate }" to="/projects" custom>
              <a
                :href="href"
                data-cy="projects-index-button-sidebar"
                class="flex h-6 w-6 items-center justify-center rounded text-gray-500 hover:bg-gray-700 hover:text-gray-300 ltr:mr-2 rtl:ml-2"
                @click.stop="navigate"
              >
                <FolderOpenIcon class="h-3.5 w-3.5" />
              </a>
            </RouterLink>

            <span
              v-if="can('project:create')"
              data-cy="create-project-button-sidebar"
              class="flex h-6 w-6 items-center justify-center rounded text-gray-500 hover:bg-gray-700 hover:text-gray-300 ltr:mr-2 rtl:ml-2"
              @click.stop="projectStore.create"
            >
              <PlusIcon class="h-4 w-4" />
            </span>
          </div>
        </div>
      </template>

      <template #content>
        <div class="mt-2.5 space-y-1">
          <Item
            v-for="item in store.items"
            :key="item.id"
            :name="item.name"
            :color="item.meta.color"
            :to="`/projects/${item.id}`"
          />
        </div>
      </template>
    </Collapsible>
  </section>
</template>

<script setup lang="ts">
  import { Collapsible } from 'thetheme'
  import { ChevronDownIcon, FolderOpenIcon, PlusIcon } from '@heroicons/vue/24/outline'
  import { useProjectStore } from 'Store/project'
  import { useSidebarProjectStore } from 'Store/sidebar-project'
  import Item from './Item.vue'

  const projectStore = useProjectStore(),
    store = useSidebarProjectStore()
</script>
