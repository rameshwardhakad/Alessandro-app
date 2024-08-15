<template>
  <div class="px-6 pb-7 pt-6">
    <div class="mb-4 flex items-center">
      <h1 class="text-xl font-semibold text-gray-900" data-cy="page-title">
        {{ __(`Team Members`) }} ({{ store.selected.length }})
      </h1>

      <span
        class="flex h-7 w-7 cursor-pointer items-center justify-center rounded text-gray-400 hover:bg-gray-200 hover:text-gray-500 ltr:ml-auto rtl:mr-auto"
        @click="useModalsStore().pop()"
      >
        <XMarkIcon class="h-6 w-6" />
      </span>
    </div>

    <div class="mb-4 flex flex-1 items-center ltr:pl-px rtl:pr-px">
      <span
        class="block cursor-pointer text-xs text-gray-600 hover:text-gray-900"
        @click="store.selectAll"
      >
        {{ __('Select All') }}
      </span>
      <span class="block px-1 text-xs text-gray-600">/</span>
      <span
        class="block cursor-pointer text-xs text-gray-600 hover:text-gray-900"
        @click="store.deselectAll"
      >
        {{ __('Deselect All') }}
      </span>
    </div>

    <input
      v-model="store.search"
      type="search"
      :placeholder="__('Search')"
      class="-mb-px block w-full rounded-t-md border-gray-200 px-4 py-2.5 text-sm focus:border-gray-200 focus:ring-0 focus:ring-indigo-500"
    />

    <div
      v-if="store.filteredSelected.length || store.filteredUsers.length"
      role="list"
      class="divide-y divide-gray-200 overflow-y-auto rounded-b-md border border-gray-200"
      style="max-height: 228px"
    >
      <label
        v-for="(option, index) in store.filteredSelected"
        :key="option.id"
        class="flex cursor-pointer items-center px-4 py-3"
        @click="store.deselect(option, index)"
      >
        <div class="flex items-start">
          <UserAvatar class="h-6 w-6" :avatar="option.avatar" />
          <div class="text-sm ltr:ml-3 rtl:mr-3">
            <span class="mb-1 block truncate text-sm font-medium leading-none text-gray-900">
              {{ option.name }}
            </span>
            <span class="block truncate text-sm leading-none text-gray-500">
              {{ option.email }}
            </span>
          </div>
        </div>
        <div class="ltr:ml-auto rtl:mr-auto">
          <div class="flex h-5 w-5 items-center justify-center rounded-full bg-blue-600">
            <svg viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z"
              />
            </svg>
          </div>
        </div>
      </label>

      <label
        v-for="(option, index) in store.filteredUsers"
        :key="option.id"
        class="flex cursor-pointer items-center px-4 py-3"
        @click="store.select(option, index)"
      >
        <div class="flex items-start">
          <UserAvatar class="h-6 w-6" :avatar="option.avatar" />
          <div class="text-sm ltr:ml-3 rtl:mr-3">
            <span class="mb-1 block truncate text-sm font-medium leading-none text-gray-900">
              {{ option.name }}
            </span>
            <span class="block truncate text-sm leading-none text-gray-500">
              {{ option.email }}
            </span>
          </div>
        </div>
        <div class="ltr:ml-auto rtl:mr-auto">
          <div class="h-5 w-5 rounded-full border border-gray-300">&nbsp;</div>
        </div>
      </label>
    </div>

    <div v-else class="border border-gray-200 py-10 text-center text-sm text-gray-600">
      {{ __('No user found!') }}
    </div>
  </div>

  <div class="flex justify-end rounded-b-lg bg-gray-50 px-6 py-5">
    <TheButton
      size="sm"
      class="ltr:mr-3 rtl:ml-3"
      white
      :disabled="store.submitting"
      @click="useModalsStore().pop()"
    >
      {{ __('Cancel') }}
    </TheButton>

    <TheButton
      size="sm"
      data-cy="submit-button"
      :processing="store.submitting"
      @click="store.submit"
    >
      {{ __(`Save`) }}
    </TheButton>
  </div>
</template>

<script setup lang="ts">
  import { XMarkIcon } from '@heroicons/vue/24/solid'
  import { UserAvatar } from 'thetheme'
  import { useProjectMemberStore } from 'Store/project-member'
  import { TheButton } from 'thetheme'
  import { useModalsStore } from 'spack'

  const store = useProjectMemberStore()
</script>
