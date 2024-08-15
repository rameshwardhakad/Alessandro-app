<template>
  <nav class="flex rounded-md ltr:ml-16 rtl:mr-16">
    <a
      v-for="(item, index) in items"
      :id="'project-tab' + index"
      :key="index"
      :href="getHref(item.href)"
      class="group flex items-center rounded-md px-3 py-1.5"
      :class="[
        tabStore.current == index ? 'cursor-default bg-gray-200 text-gray-800' : 'text-gray-600',
      ]"
      @click.prevent="tabStore.select(index)"
    >
      <Component :is="item.icon" class="h-4 w-4 group-hover:text-gray-800" />

      <span class="text-sm font-medium group-hover:text-gray-800 ltr:ml-2 rtl:mr-2">
        {{ __(item.label) }}
      </span>
    </a>
  </nav>
</template>

<script setup lang="ts">
  import { useTabStore } from 'spack'
  import { ListBulletIcon, ViewColumnsIcon } from '@heroicons/vue/24/outline'

  const tabStore = useTabStore()()

  const baseURL = window.location.origin + window.location.pathname

  const items = [
    {
      href: '',
      icon: ViewColumnsIcon,
      label: 'Board',
    },
    {
      href: '?archived',
      icon: ListBulletIcon,
      label: 'List',
    },
  ]

  function getHref(href: string) {
    return baseURL + href
  }
</script>
