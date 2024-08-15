<template>
  <FormModal :id="id" :name="name" uri="front/features">
    <FieldText name="title" label="Title" class="col-span-12" />
    <FieldTextarea name="description" label="Description" class="col-span-12" />
  </FormModal>
</template>

<script setup lang="ts">
  import { FieldText, FieldTextarea, FormModal } from 'thetheme'
  import { useFormStore, useIndexStore, useModalsStore } from 'spack'

  const { id } = defineProps<{
    id?: number
  }>()

  const index = useIndexStore('feature')()
  const name = 'feature'
  const form = useFormStore<any>(name)()

  form.onSuccess((response) => {
    console.log('response')
    console.log(response)
    console.log('form', form.id)

    if (id) {
      const indexItem = index.data.data.findIndex((x: any) => x.id === form.id)
      index.data.data[indexItem] = response.model
    } else {
      index.data.data.push(response.model)
    }

    useModalsStore().pop()
  })
</script>
