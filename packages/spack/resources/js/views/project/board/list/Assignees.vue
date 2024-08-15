<template>
  <div v-if="plus" class="flex items-center py-1 ltr:ml-auto rtl:mr-auto">
    <UserAvatar class="h-4 w-4" :avatar="users[0]?.avatar" />

    <span v-show="plus - 1" class="text-[9px] text-gray-600 ltr:ml-0.5 rtl:mr-0.5">
      +{{ plus - 1 }}
    </span>
  </div>
</template>

<script setup lang="ts">
  import { UserAvatar } from 'thetheme'

  defineProps<{
    users: any
    plus: number
  }>()
</script>
