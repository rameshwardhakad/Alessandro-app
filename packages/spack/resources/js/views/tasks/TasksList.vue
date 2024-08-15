<template>
  <Card>
    <div class="border-b border-gray-200 px-6 py-4">
      <h3 class="flex items-center text-base font-medium leading-6 text-gray-900">
        {{ __(title) }}
        <span class="block text-sm font-normal text-gray-800 ltr:pl-2 rtl:pr-2">({{ total }})</span>
      </h3>
    </div>
    <div class="space-y-4 divide-y pb-4">
      <div v-for="task in tasks" :key="task.id" class="flex items-start px-6 pt-4">
        <div class="-mt-1">
          <span class="block cursor-pointer hover:underline" @click="openModal(task.id)">
            {{ task.title }}
          </span>

          <div class="mt-1.5 flex space-x-4 rtl:space-x-reverse">
            <div v-if="task.due_at" class="flex items-center py-1">
              <CalendarIcon class="h-4 w-4 text-gray-400" />
              <span class="text-xs text-gray-500 ltr:ml-2 rtl:mr-2">{{ task.human_due_date }}</span>
            </div>

            <RouterLink v-slot="{ href, navigate }" custom :to="'/projects/' + task.project_id">
              <a
                :href="href"
                class="flex cursor-pointer items-center text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:underline"
                @click="navigate"
              >
                <span
                  class="block h-2 w-2 flex-shrink-0 rounded-full"
                  :style="{ 'background-color': task.project.meta.color }"
                  aria-hidden="true"
                ></span>
                <span class="truncate text-xs text-gray-500 ltr:ml-2 rtl:mr-2">
                  {{ task.project.name }}
                </span>
              </a>
            </RouterLink>
          </div>
        </div>

        <div class="flex flex-shrink-0 -space-x-1 ltr:ml-auto rtl:mr-auto">
          <UserAvatar
            v-for="user in task.users"
            :key="user.id"
            class="h-6 w-6 max-w-none rounded-full ring-2 ring-white"
            :avatar="user.avatar"
            data-cooltipz-dir="bottom"
            :aria-label="user.name"
          />
        </div>
      </div>
    </div>
  </Card>
</template>

<script setup lang="ts">
  import { Card, UserAvatar } from 'thetheme'
  import { CalendarIcon } from '@heroicons/vue/24/outline'
  import { useModalsStore } from 'spack'
  import TaskModal from 'View/task/Index.vue'
  import type { ConcreteComponent } from 'vue'
  import { computed } from 'vue'

  const { tasks } = defineProps<{
    title: string
    tasks: any[]
  }>()

  const total = computed(() => tasks.length)

  function openModal(id = null) {
    useModalsStore().add(TaskModal as ConcreteComponent, {
      id,
      width: 'max-w-3xl',
    })
  }
</script>
