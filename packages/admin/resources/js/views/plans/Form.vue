<template>
  <FormModal :id="id" :name="name" uri="plans">
    <FieldText name="name" :label="__('Name')" class="col-span-12" />
    <FieldText name="short_description" :label="__('Short Description')" class="col-span-12" />
    <FieldText
      name="monthly_price"
      :label="__('Monthly Price')"
      class="col-span-12"
      type="number"
    />
    <FieldText name="stripe_plan_id" :label="__('Stripe Plan ID')" class="col-span-12" />
    <FieldText
      name="projects"
      :label="__('Projects')"
      class="col-span-12"
      type="number"
      info="leave blank for unlimited projects"
    />
    <FieldText
      name="users"
      :label="__('Users')"
      class="col-span-12"
      type="number"
      info="leave blank for unlimited users"
    />
    <FieldTextarea
      name="features"
      :label="__('Features')"
      class="col-span-12"
      info="These features will be shown on the pricing plan"
    />
  </FormModal>
</template>

<script setup lang="ts">
  import { FieldText, FieldTextarea, FormModal } from 'thetheme'
  import { useFormStore, useModalsStore } from 'spack'
  import { usePlanIndex } from 'Use/plan/Index'

  defineProps<{
    id?: number
  }>()

  const name = 'plan'
  const form = useFormStore(name)()
  const planIndex = usePlanIndex()

  form.onSuccess((response) => {
    console.log('response')
    console.log(response)
    console.log('form', form.id)

    if (form.id !== null) {
      planIndex.update(form.id, response.model)
    } else {
      planIndex.prepend(response.model)
    }

    useModalsStore().pop()
  })
</script>
