<template>
  <SettingsLayout>
    <FormBase name="setting-front-social" uri="settings/front/social" title="Social" save-only>
      <FieldText name="social_facebook" :label="__('Facebook')" inline />
      <FieldText name="social_twitter" :label="__('Twitter')" inline />
      <FieldText name="social_instagram" :label="__('Instagram')" inline />
      <FieldText name="social_gitHub" :label="__('Github')" inline />
      <FieldText name="social_dribbble" :label="__('Dribbble')" inline />
    </FormBase>
  </SettingsLayout>
</template>

<script setup lang="ts">
  import { useFormStore } from 'spack'
  import SettingsLayout from '../SettingsLayout.vue'
  import { FieldText, FormBase } from 'thetheme'

  const form = useFormStore('setting-front-social')()

  form.onSuccess(() => {
    form.submitting = false
  })
</script>
