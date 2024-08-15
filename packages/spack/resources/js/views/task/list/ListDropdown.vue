<template>
  <Dropdown>
    <template #trigger>
      <div
        class="group mt-2 flex cursor-pointer items-center rounded-md px-2 py-2 hover:bg-gray-200"
      >
        <span class="block h-3.5 text-xs leading-none text-gray-600">
          {{ list.name }}
        </span>

        <ChevronDownIcon
          class="hidden h-3.5 w-3.5 text-gray-500 group-hover:block ltr:ml-auto rtl:mr-auto"
        />
      </div>
    </template>

    <template #content>
      <div class="dropdown-card right w-48">
        <div class="py-1">
          <span
            v-for="option in listOptions"
            :key="option.label"
            class="flex cursor-pointer items-center px-4 py-2 text-xs text-gray-600 hover:bg-gray-200"
            @click="update(option)"
          >
            {{ option.label }}
            <CheckIcon
              v-if="option.value == list.id"
              class="h-4 w-4 text-gray-500 ltr:ml-auto rtl:mr-auto"
            />
          </span>
        </div>
      </div>
    </template>
  </Dropdown>
</template>

<script setup lang="ts">
  import { Dropdown } from 'thetheme'
  import { useTaskState } from 'Use/task'
  import { useTaskListUpdate } from 'Use/task/listUpdate'
  import { CheckIcon } from '@heroicons/vue/20/solid'
  import { ChevronDownIcon } from '@heroicons/vue/24/outline'

  const { list, listOptions } = useTaskState()
  const { update } = useTaskListUpdate()
</script>
