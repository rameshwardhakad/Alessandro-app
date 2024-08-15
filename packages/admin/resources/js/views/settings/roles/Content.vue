<template>
  <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <TableTh name="role" :index="indexUser" :label="__('Role')" />
          <TableTh name="role" :index="indexUser" :label="__('Permissions')" align="center" />
          <th class="bg-gray-50 px-6 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="item in indexUser.data" :key="item.id">
          <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-500">
            {{ item.name }}
          </td>

          <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-500">
            {{ item.permissions_count }}
          </td>

          <td
            class="flex items-center justify-end whitespace-nowrap px-6 py-4 text-right text-sm font-medium leading-5"
          >
            <span
              v-if="can('role:update') && item.id !== 1"
              class="ltr:ml-2 rtl:mr-2"
              @click="edit(item.id)"
            >
              <PencilSquareIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800" />
            </span>

            <TrashIcon
              v-if="can('role:delete') && item.id !== 1"
              class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ltr:ml-2 rtl:mr-2"
              @click.prevent="indexUser.deleteIt(item.id)"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
  import { useIndexStore, useModalsStore } from 'spack'
  import { TableTh } from 'thetheme'
  import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'
  import Form from './Form.vue'

  const indexUser = useIndexStore('role')()

  function edit(id: number) {
    useModalsStore().add(Form, { id })
  }
</script>
