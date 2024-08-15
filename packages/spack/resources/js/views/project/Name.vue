<template>
  <h2
    ref="heading"
    :contenteditable="isEditing"
    class="rounded px-2 text-xl/7 font-medium text-gray-800 hover:bg-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-600"
    :class="{ 'cursor-pointer': !isEditing, 'cursor-text': isEditing }"
    @click="onEdit"
    @blur="onUpdate"
    @keydown.enter="onUpdate"
  >
    {{ project.name }}
  </h2>
</template>

<script setup lang="ts">
  import { nextTick, ref } from 'vue'
  import { useProjectDetailStore } from 'Store/project-detail'

  const heading = ref<HTMLInputElement | null>(null)
  const isEditing = ref(false)
  const { onNameUpdate, project } = useProjectDetailStore()

  function onEdit() {
    if (isEditing.value) {
      return
    }

    isEditing.value = true

    nextTick(() => {
      heading.value?.focus()
    })
  }

  function onUpdate(event: Event) {
    isEditing.value = false

    if (event instanceof KeyboardEvent && event.key === 'Enter') {
      event.preventDefault()
    }

    (event.target as HTMLElement).blur()

    onNameUpdate(heading.value?.textContent as string)
  }
</script>
