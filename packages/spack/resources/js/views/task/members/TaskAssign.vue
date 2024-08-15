<template>
  <Dropdown name="task-assign" :modal="true" close-outside>
    <template #trigger>
      <span class="cursor-pointer">
        <PlusSvg class="h-4 w-4 text-gray-600 hover:text-gray-800" />
      </span>
    </template>

    <template #content>
      <div
        class="absolute z-40 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none ltr:right-0 ltr:origin-top-right rtl:left-0 rtl:origin-top-left"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu"
      >
        <div
          v-for="user in userOptions"
          :key="user.id"
          class="flex items-center px-4 py-2 text-sm hover:bg-gray-200"
          :class="{ 'cursor-pointer': can('task:update') }"
          @click="choose(user)"
        >
          <span
            v-if="users.find((x: any) => x.id == user.id) ? true : false"
            class="inline-block h-5 w-5 rounded-full bg-blue-400 text-white"
          >
            <svg viewBox="0 0 16 16" fill="white">
              <path
                d="M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z"
              />
            </svg>
          </span>

          <UserAvatar v-else class="h-5 w-5" :avatar="user.avatar" />

          <span class="block text-gray-600 ltr:ml-2 rtl:mr-2">{{ user.name }}</span>
        </div>
      </div>
    </template>
  </Dropdown>
</template>

<script setup lang="ts">
  import { Dropdown, UserAvatar } from 'thetheme'
  import { useTaskState } from 'Use/task'
  import { axios, useIndexStore } from 'spack'
  import PlusSvg from 'Component/PlusSvg.vue'
  import { useOnAssign } from 'Use/project/onAssign'

  const { task, userOptions, users } = useTaskState()

  function choose(user: any) {
    let index = users.value.findIndex((x: any) => x.id == user.id)

    index >= 0 ? unassign(user) : assign(user)
  }

  function assign(user: any) {
    users.value.push(user)

    axios
      .patch('/tasks/' + task.value.id + '/assign', {
        user: user.id,
      })
      .then(({ data }) => {
        console.log(data)
        // updateProjectDetail()

        if (window.location.href.includes('/tasks')) {
          useIndexStore('tasks')().fetch({ loading: false })
        } else {
          useOnAssign().assign(user)
        }
      })
  }

  function unassign(user: any) {
    let index = users.value.findIndex((x: any) => x.id == user.id)

    users.value.splice(index, 1)

    axios
      .patch('/tasks/' + task.value.id + '/unassign', {
        user: user.id,
      })
      .then(({ data }) => {
        console.log(data)
        // updateProjectDetail()

        if (window.location.href.includes('/tasks')) {
          useIndexStore('tasks')().fetch({ loading: false })
        } else {
          useOnAssign().unassign(user)
        }
      })
  }
</script>
