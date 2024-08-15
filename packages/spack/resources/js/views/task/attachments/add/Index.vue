<template>
  <div class="ml-auto">
    <p class="flex items-center" v-if="isFiles">
      <span class="text-xs text-gray-600 group-hover:text-gray-800 ltr:pl-2 rtl:pr-2">
        {{ __('Uploading') }} ...
      </span>
    </p>

    <label class="group flex cursor-pointer items-center" v-else>
      <input type="file" class="hidden" multiple @change="onFileInput" />
      <PlusIcon class="h-4 w-4 text-gray-600 group-hover:text-gray-800" />
      <span class="text-sm text-gray-600 group-hover:text-gray-800 ltr:pl-2 rtl:pr-2">
        {{ __('Add') }}
      </span>
    </label>
  </div>
</template>

<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { axios } from 'spack'
  import { useTaskState } from 'Use/task'
  import { PlusIcon } from '@heroicons/vue/24/solid'

  const { attachments, task, project } = useTaskState()
  const files = ref<any>([])
  const progress = ref<any>({})
  const filePaths = ref<any>({})

  const isFiles = computed(() => {
    return files.value.length > 0
  })

  function onFileInput(e: any) {
    console.log('hit onFileInput')
    console.log(e.target.files)
    e.preventDefault()
    files.value = [...e.target.files]

    console.log(files.value)

    for (let i = 0; i < files.value.length; i++) {
      handleFile(i)
    }
  }

  function handleFile(index: number) {
    const file = files.value[index]
    const reader = new FileReader()

    reader.readAsDataURL(file)
    reader.onload = () => {
      const formData = new FormData()

      formData.append('file', file as Blob)
      formData.append('name', file.name)
      formData.append('project_id', project.value.id.toString())
      formData.append('task_id', task.value.id.toString())

      axios
        .post('attachments', formData, {
          onUploadProgress: function (progressEvent: any) {
            console.log('progressEvent')
            console.log(progressEvent)
            console.log(Math.round((progressEvent.loaded * 100) / progressEvent.total))
            progress.value[index] = {
              progress: Math.round((progressEvent.loaded * 100) / progressEvent.total) - 5,
              failed: false,
              success: false,
            }
          },
        })
        .then(({ data }) => {
          console.log('data')
          console.log(data)
          attachments.value.push(data)

          files.value.splice(index, 1)

          filePaths.value[index] = { path: data, name: file.name }
          progress.value[index] = { progress: 100, failed: false, success: true }
        })
        .catch((error: any) => {
          console.log(error)

          files.value.splice(index, 1)

          progress.value[index] = { progress: 95, failed: true, success: false }
        })
    }
  }
</script>
