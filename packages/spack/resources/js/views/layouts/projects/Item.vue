<template>
  <RouterLink v-slot="{ isActive, href, navigate }" :to="to" custom>
    <a
      :href="href"
      :class="[
        'group flex items-center rounded-md px-3 py-2 text-sm font-medium',
        isActive ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white',
      ]"
      @click="navigate"
    >
      <span
        class="h-2.5 w-2.5 rounded-full ltr:ml-1 ltr:mr-4 rtl:ml-4 rtl:mr-1"
        :style="{ 'background-color': color }"
      />

      <span class="flex-1 truncate">{{ name }}</span>
    </a>
  </RouterLink>
</template>

<script setup lang="ts">
  defineProps<{
    name: string
    color: string
    to: string
  }>()
</script>
