<template>
  <SettingsLayout>
    <FormBase name="setting-front-general" uri="settings/front/general" title="General" save-only>
      <FieldText name="front_site_heading" :label="__('Heading')" inline />
      <FieldText name="front_site_short_description" :label="__('Short Description')" inline />
      <FieldText name="front_site_copyright" :label="__('Copyright')" inline />
      <FieldLogo />

      <div
        v-if="config.is_standalone_demo"
        class="grid border-b border-gray-200 py-5 last:border-b-0 sm:grid-cols-3"
      >
        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">&nbsp;</label>
        <div class="py-2 text-sm text-red-600 sm:col-span-2">
          Note: Only language and direction will take effect in this demo!
        </div>
      </div>
    </FormBase>
  </SettingsLayout>
</template>

<script setup lang="ts">
  import { useFormStore } from 'spack'
  import SettingsLayout from '../SettingsLayout.vue'
  import FieldLogo from './FieldLogo.vue'
  import { FieldText, FormBase } from 'thetheme'
  import { appData } from '@/app-data'

  const config = appData
  const form = useFormStore('setting-front-general')()

  form.onSuccess(() => {
    form.submitting = false
  })
</script>
