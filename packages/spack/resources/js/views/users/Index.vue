<template>
  <div v-if="indexUser.fetching" class="mt-12 flex justify-center">
    <Loader color="text-gray-600" />
  </div>

  <PageContainer v-else>
    <div class="mb-4 flex">
      <h1 class="text-2xl font-semibold text-gray-900">{{ __('Team Members') }}</h1>

      <div class="flex ltr:ml-auto rtl:mr-auto">
        <button
          v-if="can('user:create')"
          type="button"
          class="rounded-md bg-blue-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 ltr:ml-4 rtl:mr-4"
          @click="useUserFormModal().create"
        >
          {{ __('Create Member') }}
        </button>
      </div>
    </div>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <TableTh name="user" :index="indexUser" :label="__('Name')" sort="name" />
                  <TableTh name="user" :index="indexUser" :label="__('Role')" />
                  <th class="bg-gray-50 px-6 py-3"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="item in indexUser.data.data" :key="item.id">
                  <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-500">
                    <div class="flex">
                      <UserAvatar class="h-6 w-6" :avatar="item.avatar" />
                      <div class="text-sm ltr:ml-3 rtl:mr-3">
                        <span
                          class="mb-1 block truncate text-sm font-medium leading-none text-gray-900"
                        >
                          {{ item.name }}
                        </span>
                        <span class="block text-sm font-normal text-gray-500">
                          {{ item.email }}
                        </span>
                      </div>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-500">
                    {{ item.roles[0].name }}
                  </td>

                  <td
                    class="flex items-center justify-end whitespace-nowrap px-6 py-4 text-right text-sm font-medium leading-5"
                  >
                    <span
                      v-if="can('user:update')"
                      class="ml-2"
                      @click="useUserFormModal().edit(item.id)"
                    >
                      <PencilSquareIcon
                        class="w-5 cursor-pointer text-gray-400 hover:text-gray-800"
                      />
                    </span>

                    <TrashIcon
                      v-if="can('user:delete')"
                      class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ltr:ml-2 rtl:mr-2"
                      @click.prevent="indexUser.deleteIt(item.id)"
                    />
                  </td>
                </tr>
              </tbody>
            </table>

            <IndexPagination :index="indexUser" />
          </div>
        </div>
      </div>
    </div>
  </PageContainer>
</template>

<script setup lang="ts">
  import { useUserFormModal } from 'Use/userFormModal'
  import { useIndexStore } from 'spack'
  import { IndexPagination, Loader, PageContainer, TableTh, UserAvatar } from 'thetheme'
  import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'

  const indexUser = useIndexStore('user')()

  indexUser.setConfig({
    uri: 'users',
    orderByDirection: 'desc',
  })

  indexUser.fetch()
</script>
