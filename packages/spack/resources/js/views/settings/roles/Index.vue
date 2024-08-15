<template>
  <SettingsLayout>
    <template #topbar>
      <TheButton
        v-if="can('role:create')"
        class="ltr:ml-auto rtl:mr-auto"
        size="sm"
        data-cy="topbar-create-button"
        @click="create"
      >
        {{ __('Create Role') }}
      </TheButton>
    </template>

    <Loader v-if="indexUser.fetching" class="mx-auto" color="text-gray-500" />
    <Content v-else />
  </SettingsLayout>
</template>

<script setup lang="ts">
  import { useIndexStore, useModalsStore } from 'spack'
  import { Loader, TheButton } from 'thetheme'
  import Form from './Form.vue'
  import Content from './Content.vue'
  import SettingsLayout from 'View/settings/SettingsLayout.vue'

  const indexUser = useIndexStore('role')()

  indexUser.setConfig({
    uri: 'roles',
    orderByDirection: 'desc',
  })

  indexUser.fetch()

  function create() {
    useModalsStore().add(Form)
  }
</script>
