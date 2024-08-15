<template>
  <h2
    ref="heading"
    class="flex-1 rounded-lg py-1.5 text-sm font-semibold text-gray-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-600 ltr:pl-3 ltr:pr-2 rtl:pl-2 rtl:pr-3"
    :class="{
      'cursor-pointer': !isEditing && can('project-list:update'),
      'cursor-text': isEditing,
    }"
    :contenteditable="isEditing"
    @click="onEdit"
    @blur="onUpdate"
    @keydown.enter.prevent="onEnter"
    @focus="moveCursorToEnd"
  >
    {{ name }}
  </h2>
</template>

<script setup lang="ts">
  import { nextTick, ref } from 'vue'
  import { useList } from 'Use/list'
  import { cannot } from 'spack'

  const props = defineProps<{
    id: number
    index: number
    name: string
  }>()

  const heading = ref<HTMLInputElement | null>(null)
  const isEditing = ref(false)
  const name = ref(props.name)

  const { updateListName } = useList()

  function onEdit() {
    if (cannot('project-list:update')) return

    if (isEditing.value) return

    isEditing.value = true

    nextTick(() => heading.value?.focus())
  }

  function moveCursorToEnd() {
    const selection = window.getSelection()
    const range = document.createRange()
    if (heading.value) {
      range.selectNodeContents(heading.value)
      range.collapse(false)
      selection?.removeAllRanges()
      selection?.addRange(range)
    }
  }

  function onEnter(event: KeyboardEvent) {
    ;(event.target as HTMLElement).blur()
  }

  function onUpdate(event: Event) {
    console.log('hit onUpdate')

    isEditing.value = false

    const text = (event.target as HTMLElement).textContent as string

    if (text === props.name || text.trim() === '') {
      name.value = text

      setTimeout(() => (name.value = props.name))

      return
    }

    updateListName(props.id, props.index, text)
  }
</script>
