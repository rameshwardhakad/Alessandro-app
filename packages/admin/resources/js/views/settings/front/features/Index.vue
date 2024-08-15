<template>
  <SettingsLayout>
    <template #topbar>
      <TheButton
        class="ltr:ml-auto rtl:mr-auto"
        size="sm"
        data-cy="topbar-create-button"
        @click="create"
      >
        {{ __('Create Feature') }}
      </TheButton>
    </template>

    <Loader v-if="index.fetching" class="mx-auto" color="text-gray-500" />
    <div v-else>
      <IndexNoData v-if="index.data.data.length == 0" />
      <Content v-else />
    </div>
  </SettingsLayout>
</template>

<script setup lang="ts">
  import { useIndexStore, useModalsStore } from 'spack'
  import { Loader, TheButton, IndexNoData } from 'thetheme'
  import Form from './Form.vue'
  import Content from './Content.vue'
  import SettingsLayout from 'View/settings/SettingsLayout.vue'

  const index = useIndexStore('feature')()

  index.setConfig({
    uri: 'front/features',
  })

  index.fetch()

  function create() {
    useModalsStore().add(Form)
  }
</script>
