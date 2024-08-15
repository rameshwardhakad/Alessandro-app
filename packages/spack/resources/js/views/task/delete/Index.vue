<template>
  <section class="py-3">
    <h2 class="px-2 text-sm font-medium text-gray-600">{{ __('Delete') }}</h2>

    <div v-if="isDeleteConfirm" class="mt-2 space-y-2 px-2">
      <button
        class="flex w-full items-center rounded border border-transparent bg-red-500 px-2.5 py-1.5 text-xs font-medium text-white focus:outline-none focus:ring-0 hover:enabled:bg-red-600 disabled:opacity-50"
        :disabled="processing"
        @click="archive"
      >
        <TrashIcon class="h-3.5 w-3.5 ltr:mr-2 rtl:ml-2" />
        {{ __('Are you sure') }}
      </button>

      <button
        class="flex w-full items-center rounded border border-transparent bg-gray-200 px-2.5 py-1.5 text-xs font-medium text-gray-500 focus:outline-none focus:ring-0 hover:enabled:text-gray-700 disabled:opacity-50"
        :disabled="processing"
        @click="isDeleteConfirm = false"
      >
        <ArrowUturnLeftIcon class="h-3.5 w-3.5 ltr:mr-2 rtl:ml-2" />
        {{ __('Cancel') }}
      </button>
    </div>

    <div v-else class="mt-2 space-y-2 px-2">
      <button
        class="flex w-full items-center rounded border border-transparent bg-gray-200 px-2.5 py-1.5 text-xs font-medium text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-0"
        @click="isDeleteConfirm = true"
      >
        <TrashIcon class="h-3.5 w-3.5 ltr:mr-2 rtl:ml-2" />
        {{ __('Delete') }}
      </button>
    </div>
  </section>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { TrashIcon } from '@heroicons/vue/24/outline'
  import { ArrowUturnLeftIcon } from '@heroicons/vue/24/solid'
  import { useTaskState } from 'Use/task'
  import { axios, useIndexStore, useModalsStore } from 'spack'
  import { useOnDelete } from 'Use/project/onDelete'

  const { project, task } = useTaskState()
  const processing = ref(false)
  const isDeleteConfirm = ref(false)

  function archive() {
    if (processing.value) return

    processing.value = true

    axios.patch('tasks/' + task.value.id + '/archive').then(() => {
      processing.value = false
      task.value.deleted_at = 'archived'
      close()
    })
  }

  function close() {
    if (window.location.href.includes('/tasks')) {
      useIndexStore('tasks')().fetch({ loading: false })
      useModalsStore().pop()

      return
    }

    const url = `/projects/${project.value.id}`
    history.replaceState(history.state, '', url)

    useModalsStore().pop()

    useOnDelete().update()
  }
</script>
