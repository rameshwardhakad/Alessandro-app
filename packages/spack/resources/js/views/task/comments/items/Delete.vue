<template>
  <div
    v-if="deleteConfirmation"
    class="absolute right-0 flex items-center bg-white ltr:pl-4 rtl:pr-4"
    :class="{ 'opacity-50': processing }"
  >
    <span class="text-sm text-gray-600 ltr:mr-2 rtl:ml-2">{{ __('Are you sure to delete?') }}</span>
    <CheckCircleIcon
      class="h-5 w-5 cursor-pointer text-green-600 hover:text-green-800 ltr:mr-1 rtl:ml-1"
      @click="deleteComment"
    />
    <XCircleIcon
      class="h-5 w-5 cursor-pointer text-red-600 hover:text-red-800"
      @click="deleteConfirmation = false"
    />
  </div>

  <div
    v-else
    aria-label="Delete"
    data-cooltipz-dir="top"
    class="absolute hidden bg-white group-hover:flex ltr:right-0 rtl:left-0"
  >
    <TrashIcon
      v-if="comment.user_id == appData.user.id"
      class="h-4 w-4 cursor-pointer text-gray-500 hover:text-gray-900"
      @click="deleteConfirmation = true"
    />
  </div>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { useTaskState } from 'Use/task'
  import { appData } from '@/app-data'
  import { axios } from 'spack'
  import { CheckCircleIcon, TrashIcon, XCircleIcon } from '@heroicons/vue/24/outline'
  import { useOnComment } from 'Use/project/onComment'

  const { comments } = useTaskState()
  const deleteConfirmation = ref(false)
  const processing = ref(false)

  const props = defineProps<{
    index: number
    comment: any
  }>()

  function deleteComment() {
    processing.value = true

    axios.delete(`/comments/${props.comment.id}`).then(() => {
      comments.value.splice(comments.value.indexOf(props.comment.id), 1)
      processing.value = false
      deleteConfirmation.value = false

      if (window.location.href.includes('/tasks')) return

      useOnComment().remove()
    })
  }
</script>
