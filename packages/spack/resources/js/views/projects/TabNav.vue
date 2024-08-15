<template>
  <nav class="flex space-x-2 rounded-md rtl:space-x-reverse" aria-label="Tabs">
    <a
      v-for="(item, index) in items"
      :id="'project-tab' + index"
      :key="index"
      :href="getHref(item.href)"
      class="group flex items-center rounded-md px-3 py-1.5"
      :class="[active == index ? 'cursor-default bg-gray-200 text-gray-800' : 'text-gray-600']"
      @click.prevent="select(index)"
    >
      <Component :is="item.icon" class="h-4 w-4 group-hover:text-gray-800" />

      <span class="text-sm font-medium group-hover:text-gray-800 ltr:ml-2 rtl:mr-2">
        {{ __(item.label) }}
      </span>
    </a>
  </nav>
</template>

<script setup lang="ts">
  import { ArchiveBoxIcon, FolderIcon } from '@heroicons/vue/24/outline'

  const props = defineProps<{
    active: any
    select: any
    onSelect: any
  }>()

  const baseURL = window.location.origin + window.location.pathname

  const items = [
    {
      href: '',
      icon: FolderIcon,
      label: 'Active',
    },
    {
      href: '?archived',
      icon: ArchiveBoxIcon,
      label: 'Archived',
    },
  ]

  function getHref(href: string) {
    return baseURL + href
  }

  function init() {
    const params = new URLSearchParams(window.location.search)
    params.has('archived') ? props.select(1) : props.select(0)
  }

  init()

  props.onSelect((index: number) => {
    console.log('onSelect')
    console.log(index)

    if (index === 1) {
      console.log('archived')
      history.replaceState(history.state, '', '?archived')
      // document.querySelector('#project-tab' + index)?.removeAttribute('href')
      // document.querySelector('#project-tab0')?.setAttribute('href', '/projects')
    } else {
      console.log('active')
      history.replaceState(history.state, '', '/projects')
      // document.querySelector('#project-tab' + index)?.removeAttribute('href')
      // document.querySelector('#project-tab1')?.setAttribute('href', '?archived')
    }
  })
</script>
