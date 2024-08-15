<template>
  <PageContainer>
    <div class="mb-4 flex">
      <h1 class="text-2xl font-semibold text-gray-900">{{ __('Projects') }}</h1>

      <div class="flex ltr:ml-auto rtl:mr-auto">
        <TabNav
          v-if="can('project:view-archived')"
          :active="active"
          :select="select"
          :on-select="onSelect"
        />

        <button
          v-if="can('project:create')"
          type="button"
          class="rounded-md bg-blue-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 ltr:ml-4 rtl:mr-4"
          @click="projectCreate.openModal"
        >
          {{ __('Create Project') }}
        </button>
      </div>
    </div>

    <Component :is="tab" />
  </PageContainer>
</template>

<script setup lang="ts">
  import { useTab } from 'Use/tab'
  import { PageContainer } from 'thetheme'
  import { useProjectCreate } from 'Use/projectCreate'
  import TabNav from './TabNav.vue'
  import TabActive from './TabActive.vue'
  import TabArchived from './archived/Index.vue'

  const projectCreate = useProjectCreate()

  const { active, onSelect, select, tab } = useTab([
    { component: TabActive },
    { component: TabArchived },
  ])
</script>
