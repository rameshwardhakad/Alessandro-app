<template>
  <FormModal :id="id" :name="name" uri="roles">
    <FieldText name="name" label="Name" class="col-span-12" />
    <FieldPermissions />
  </FormModal>
</template>

<script setup lang="ts">
  import { FieldText, FormModal } from 'thetheme'
  import { useFormStore, useIndexStore, useModalsStore } from 'spack'
  import FieldPermissions from './FieldPermissions.vue'

  const { id } = defineProps<{
    id?: number
  }>()

  const indexRole = useIndexStore('role')()
  const name = 'role'
  const form = useFormStore<any>(name)()

  form.onSuccess((response) => {
    console.log('response')
    console.log(response)
    console.log('form', form.id)

    if (id) {
      const index = indexRole.data.findIndex((x: any) => x.id === form.id)
      indexRole.data[index] = response.model
    } else {
      indexRole.data.push(response.model)
    }

    useModalsStore().pop()
  })
</script>
