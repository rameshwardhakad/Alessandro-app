<template>
  <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="item in index.data.data" :key="item.id">
          <td class="px-6 py-4 text-sm font-medium text-gray-500">
            {{ item.name }}
            <p class="text-sm mt-1 font-normal">{{ item.meta.description }}</p>
          </td>

          <td
            class="flex items-center justify-end whitespace-nowrap px-6 py-4 text-right text-sm font-medium leading-5"
          >
            <span class="ltr:ml-2 rtl:mr-2" @click="edit(item.id)">
              <PencilSquareIcon class="w-5 cursor-pointer text-gray-400 hover:text-gray-800" />
            </span>

            <TrashIcon
              class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ltr:ml-2 rtl:mr-2"
              @click.prevent="index.deleteIt(item.id)"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
  import { useIndexStore, useModalsStore } from 'spack'
  import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'
  import Form from './Form.vue'

  const index = useIndexStore('feature')()

  function edit(id: number) {
    useModalsStore().add(Form, { id })
  }
</script>
