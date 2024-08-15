<template>
  <div class="flex flex-shrink-0 -space-x-1 ltr:ml-16 rtl:mr-16">
    <UserAvatar
      v-for="user in store.project.users"
      :key="user.id"
      class="h-6 w-6 max-w-none rounded-full ring-2 ring-white"
      :avatar="user.avatar"
      data-cooltipz-dir="bottom"
      :aria-label="user.name"
    />
    <!-- <UserAvatar
      v-for="user in project.data.users"
      :key="user.id"
      class="h-6 w-6 max-w-none rounded-full ring-2 ring-white"
      :avatar="user.avatar"
      data-cooltipz-dir="bottom"
      :aria-label="user.name"
    /> -->
    <MemberAdd v-if="can('project:add/remove-user')" />
  </div>
</template>

<script setup lang="ts">
  import { UserAvatar } from 'thetheme'
  import MemberAdd from './MemberAdd.vue'
  import { useProjectDetailStore } from 'Store/project-detail'

  const store = useProjectDetailStore()
</script>
