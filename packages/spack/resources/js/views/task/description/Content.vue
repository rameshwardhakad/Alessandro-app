<template>
  <article
    class="prose prose-sm -mt-1 break-all p-0 text-sm text-gray-700"
    @click="showForm"
    v-html="marked.parse(task.description || '', { breaks: true, renderer })"
  />
</template>

<script setup lang="ts">
  import { marked } from 'marked'
  import { useTaskState } from 'Use/task'
  import { useTaskDescriptionForm } from 'Use/task/descriptionForm'

  const { task } = useTaskState()
  const { showForm } = useTaskDescriptionForm()

  const renderer = new marked.Renderer()
  const linkRenderer = renderer.link
  renderer.link = (href: string, title: string, text: string) => {
    const html = linkRenderer.call(renderer, href, title, text)
    return html.replace(
      /^<a /,
      `<a onclick="event.stopPropagation()" target="_blank" rel="noreferrer noopener nofollow" `,
    )
  }
</script>
