<template>
  <div class="flex flex-shrink-0 -space-x-1">
    <UserAvatar
      v-for="user in users"
      :key="user.id"
      class="h-5 w-5 max-w-none rounded-full ring-2 ring-white"
      :avatar="user.avatar"
      data-cooltipz-dir="bottom"
      :aria-label="user.name"
    />
  </div>
</template>

<script setup lang="ts">
  import { UserAvatar } from 'thetheme'

  defineProps<{
    users: any
  }>()
</script>
