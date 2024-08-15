<template>
  <Dropdown @toggle="onOpen">
    <template #trigger>
      <button
        class="relative bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none"
        aria-label="Notifications"
      >
        <BellIcon class="h-6 w-6" />
        <div
          v-if="count"
          class="absolute -top-0.5 z-40 flex h-[1.125rem] w-[1.125rem] items-center justify-center rounded-full bg-red-600 text-[0.65rem] text-white ltr:-right-0.5 rtl:-left-0.5"
        >
          {{ count > 9 ? '9+' : count }}
        </div>
      </button>
    </template>

    <template #content>
      <div
        class="absolute mt-1 w-48 origin-top-right overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none ltr:right-0 rtl:left-0"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu"
      >
        <p v-if="!notifications.length" class="py-4 text-center text-sm text-gray-700">
          {{ __('No Notifications!') }}
        </p>

        <div v-else>
          <router-link
            v-for="notification in notifications"
            v-slot="{ href, navigate }"
            :key="notification.id"
            custom
            :to="getUrl(notification)"
          >
            <a
              :href="href"
              class="block px-4 py-2 text-sm text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100"
              role="menuitem"
              @click="navigate"
            >
              {{ notification.data.message }}
            </a>
          </router-link>
        </div>
      </div>
    </template>
  </Dropdown>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import { axios } from 'spack'
  import { Dropdown } from 'thetheme'
  // import Echo from 'laravel-echo'
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  import Pusher from 'pusher-js'
  // import { appData } from '@/app-data'
  import { BellIcon } from '@heroicons/vue/24/outline'

  const notifications = ref<any>([]),
    count = ref()

  // @ts-ignore
  window.Pusher = Pusher

  // const E = new Echo({
  //   broadcaster: 'pusher',
  //   key: appData.PUSHER_APP_KEY,
  //   cluster: appData.PUSHER_APP_CLUSTER,
  //   forceTLS: true,
  // })

  // E.private(`App.Models.User.${appData.user.id}`).notification(
  //   (notification: any) => {
  //     console.log('notification')
  //     console.log(notification)
  //     count.value = count.value + 1
  //     notifications.value.push({
  //       type: notification.type,
  //       data: {
  //         item_id: notification.item_id,
  //         project_id: notification.project_id,
  //         message: notification.message,
  //       },
  //     })
  //   },
  // )

  axios.get('notifications').then((response) => {
    count.value = response.data.new
    notifications.value = response.data.notifications
  })

  function onOpen(payload: any) {
    if (payload && count.value) {
      axios.post('/notifications/read').then((response) => {
        if (response.data.success) count.value = 0
      })
    }
  }

  function getUrl(notification: { type: string; data: any }) {
    const types: any = {
      'App\\Notifications\\ProjectAssigned': '/projects/' + notification.data.item_id,
      'App\\Notifications\\TaskAssigned': '/projects/' + notification.data.project_id,
    }

    return types[notification.type]
  }
</script>
