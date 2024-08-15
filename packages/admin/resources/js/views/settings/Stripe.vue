<template>
  <SettingsLayout>
    <FormBase name="setting-stripe" uri="settings/stripe" title="Stripe" save-only>
      <FieldText type="password" name="stripe_key" :label="__('Stripe Key')" inline />
      <FieldText type="password" name="stripe_secret" :label="__('Stripe Secret')" inline />
      <FieldText type="password" name="stripe_webhook_secret" :label="__('Stripe Webhook Secret')" inline />
    </FormBase>
  </SettingsLayout>
</template>

<script setup lang="ts">
  import { useFormStore } from 'spack'
  import SettingsLayout from './SettingsLayout.vue'
  import { FieldText, FormBase } from 'thetheme'

  const form = useFormStore('setting-stripe')()

  form.onSuccess(() => location.reload())
</script>
