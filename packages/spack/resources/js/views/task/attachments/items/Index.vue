<template>
  <div class="space-y-4 pt-4">
    <div class="flex items-start" v-for="(attachment, index) in attachments" :key="attachment.name">
      <div class="h-24 w-24 bg-gray-100" v-if="attachment.is_image">
        <img class="h-24 w-24 object-contain" :src="'/' + attachment.path" />
      </div>

      <div class="flex h-24 w-24 items-center justify-center bg-gray-100" v-else>
        <span class="font-bold uppercase text-gray-800">{{ attachment.extension }}</span>
      </div>

      <div class="flex-1 pl-4">
        <a :href="'/' + attachment.path" class="text-xs text-gray-700 hover:underline">
          {{ attachment.name }}
        </a>
        <p class="mt-1 text-xs text-gray-600">Added {{ attachment.created_at }}</p>
        <div
          class="mt-2 cursor-pointer text-xs text-gray-600 hover:underline"
          @click="onDelete(attachment.id, index)"
        >
          Delete
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { axios } from 'spack'
  import { useTaskState } from 'Use/task'

  const { attachments } = useTaskState()
  const processing = ref(false)

  console.log('items')
  console.log(attachments)

  function onDelete(id: number, index: number) {
    if (processing.value) {
      return
    }

    processing.value = true

    axios
      .delete('attachments/' + id)
      .then(() => {
        console.log('deleted')
        attachments.value.splice(index, 1)
        processing.value = false
      })
      .catch(() => {
        console.log('error')
        processing.value = false
      })
  }
</script>
