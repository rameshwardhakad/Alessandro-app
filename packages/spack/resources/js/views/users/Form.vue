<template>
  <FormModal :id="id" :name="name" uri="users">
    <FieldText name="name" :label="__('Name')" class="col-span-12" />
    <FieldText name="email" :label="__('Email')" class="col-span-12" />
    <FieldText name="password" :label="__('Password')" class="col-span-12" />
    <FieldSelect name="role" :label="__('Role')" class="col-span-12" />
  </FormModal>
</template>

<script setup lang="ts">
  import { FieldSelect, FieldText, FormModal } from 'thetheme'
  import { useFormStore, useModalsStore } from 'spack'
  import { useUserIndex } from 'Use/userIndex'

  defineProps<{
    id?: number
  }>()

  const name = 'member'
  const form = useFormStore(name)()
  const userIndex = useUserIndex()

  form.onSuccess((response) => {
    console.log('response')
    console.log(response)
    console.log('form', form.id)

    if (form.id !== null) {
      userIndex.update(form.id, response.model)
    } else {
      userIndex.prepend(response.model)
    }

    // const params = new URLSearchParams(window.location.search)

    // if (form.id !== null) {
    //   const projectItemIndex = project.items.findIndex((x) => x.id == form.id)
    //   project.items[projectItemIndex] = response.model

    //   if (!params.has('archived') && Array.isArray(projectIndexStore.data)) {
    //     const projectIndexStoreItemIndex = projectIndexStore.data.findIndex(
    //       (x) => x.id == form.id
    //     )
    //     projectIndexStore.data[projectIndexStoreItemIndex] = response.model
    //   }

    //   useModalsStore().pop()
    //   return
    // }

    // if (!params.has('archived') && Array.isArray(projectIndexStore.data)) {
    //   projectIndexStore.data.push(response.model)
    // }

    // project.items.push(response.model)
    useModalsStore().pop()
  })
</script>
