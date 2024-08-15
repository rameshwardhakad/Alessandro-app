<template>
  <PageContainer>
    <div class="mb-4 flex">
      <h1 class="text-2xl font-semibold text-gray-900">{{ __('Customers') }}</h1>
    </div>

    <div class="mb-4 flex items-center">
      <IndexSearch name="customer" />
    </div>

    <div v-if="indexCustomer.fetching" class="flex justify-center">
      <Loader color="text-gray-600" />
    </div>

    <div v-else>
      <IndexNoData v-if="indexCustomer.data.data.length == 0" />

      <div class="flex flex-col" v-else>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr>
                    <TableTh
                      name="customer"
                      :index="indexCustomer"
                      :label="__('Name')"
                      sort="name"
                    />
                    <TableTh name="customer" :index="indexCustomer" :label="__('Subscription')" />
                    <TableTh name="customer" :index="indexCustomer" :label="__('Created')" />
                    <th class="bg-gray-50 px-6 py-3"></th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr v-for="item in indexCustomer.data.data" :key="item.id">
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
                      {{ item.subscription || '—' }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-500">
                      {{ item.created_at }}
                    </td>

                    <td
                      class="flex items-center justify-end whitespace-nowrap px-6 py-4 text-right text-sm font-medium leading-5"
                    >
                      &nbsp;
                    </td>
                  </tr>
                </tbody>
              </table>

              <IndexPagination :index="indexCustomer" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </PageContainer>
</template>

<script setup lang="ts">
  import { useIndexStore } from 'spack'
  import {
    IndexPagination,
    IndexNoData,
    IndexSearch,
    Loader,
    PageContainer,
    TableTh,
    UserAvatar,
  } from 'thetheme'

  const indexCustomer = useIndexStore('customer')()

  indexCustomer.setConfig({
    uri: 'customers',
  })

  indexCustomer.fetch()
</script>
