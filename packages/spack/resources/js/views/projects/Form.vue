<template>
  <FormModal :name="name" uri="projects">
    <FieldText name="name" :label="__('Name')" class="col-span-12" />
    <FieldColor name="color" />
  </FormModal>
</template>

<script setup lang="ts">
  import { FieldText, FormModal } from 'thetheme'
  import FieldColor from 'Component/FieldColor.vue'
  import { useFormStore } from 'spack'
  import { useProjectIndex } from 'Use/projectIndex'
  import { useProjectFormModal } from 'Use/projectFormModal'
  // import { useProjectIndexStore } from 'Store/project-index'

  const name = 'project'
  const form = useFormStore(name)()
  // const projectIndexStore = useProjectIndexStore()

  form.onSuccess((response) => {
    console.log(response)
    useProjectIndex().append(response.model)

    useProjectFormModal().close()

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
    // useModalsStore().pop()
  })
</script>
