<template>
  <PageContainer>
    <div class="mb-4 flex">
      <h1 class="text-2xl font-semibold text-gray-900">{{ __('Plans') }}</h1>

      <div class="flex ltr:ml-auto rtl:mr-auto">
        <button
          type="button"
          class="rounded-md bg-blue-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 ltr:ml-4 rtl:mr-4"
          @click="usePlanFormModal().create"
        >
          {{ __('Create Plan') }}
        </button>
      </div>
    </div>

    <div class="mb-4 flex items-center">
      <IndexSearch name="plan" />
    </div>

    <div v-if="indexPlan.fetching" class="flex justify-center">
      <Loader color="text-gray-600" />
    </div>

    <div v-else>
      <IndexNoData v-if="indexPlan.data.data.length == 0" />

      <div class="flex flex-col" v-else>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr>
                    <TableTh name="plan" :index="indexPlan" :label="__('Name')" sort="name" />
                    <TableTh name="plan" :index="indexPlan" :label="__('Monthly Price')" />
                    <TableTh name="plan" :index="indexPlan" :label="__('Features')" />
                    <th class="bg-gray-50 px-6 py-3"></th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr v-for="item in indexPlan.data.data" :key="item.id">
                    <td
                      class="whitespace-nowrap px-6 py-4 align-top text-sm font-medium text-gray-500"
                    >
                      {{ item.name }}
                    </td>
                    <td
                      class="whitespace-nowrap px-6 py-4 align-top text-sm font-medium text-gray-500"
                    >
                      ${{ item.meta.monthly_price }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-500">
                      <p
                        class="text-sm leading-6"
                        v-for="feature in item.meta.features"
                        :key="feature"
                        v-text="feature"
                      ></p>
                    </td>

                    <td
                      class="flex items-center justify-end whitespace-nowrap px-6 py-4 text-right text-sm font-medium leading-5"
                    >
                      <span class="ltr:ml-2 rtl:mr-2" @click="usePlanFormModal().edit(item.id)">
                        <PencilSquareIcon
                          class="w-5 cursor-pointer text-gray-400 hover:text-gray-800"
                        />
                      </span>

                      <TrashIcon
                        class="w-5 cursor-pointer text-gray-400 hover:text-gray-800 ltr:ml-2 rtl:mr-2"
                        @click.prevent="indexPlan.deleteIt(item.id)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>

              <IndexPagination :index="indexPlan" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </PageContainer>
</template>

<script setup lang="ts">
  import { useIndexStore } from 'spack'
  import { usePlanFormModal } from 'Use/plan/FormModal'
  import {
    IndexPagination,
    IndexNoData,
    IndexSearch,
    Loader,
    PageContainer,
    TableTh,
  } from 'thetheme'
  import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'

  const indexPlan = useIndexStore('plan')()

  indexPlan.setConfig({
    uri: 'plans',
  })

  indexPlan.fetch()
</script>
