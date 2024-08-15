<template>
  <div>
    <Collapsible :name="'list' + list.id" open custom-trigger>
      <template #trigger="{ open, toggle }">
        <div class="mb-2 flex items-center">
          <span
            class="flex h-6 w-6 cursor-pointer items-center justify-center rounded hover:bg-gray-200"
            @click="onToggle(open, toggle)"
          >
            <ChevronDownIcon
              class="h-4 w-4 text-gray-500"
              :class="{ 'ltr:rotate-[270deg] rtl:rotate-[90deg]': !open }"
            />
          </span>

          <Name :id="list.id" :name="list.name" :index="index" />

          <Menu v-if="can('project-list:update')" :id="list.id" :index="index" />
        </div>
      </template>

      <template #content>
        <Card :id="'list-' + index">
          <div ref="listItemsWrapper" :class="[list.tasks.length ? 'pt-2' : '']" :data-id="list.id">
            <ListItem
              v-for="(item, indexItem) in list.tasks"
              :key="item.id"
              :task="item"
              :index="indexItem"
              class="draggable-item"
            />
          </div>

          <AddTask v-if="can('task:create')" :index="index" />
        </Card>
      </template>
    </Collapsible>
  </div>
</template>

<script setup lang="ts">
  import { onMounted, ref } from 'vue'
  import { ChevronDownIcon } from '@heroicons/vue/24/solid'
  import { Card, Collapsible } from 'thetheme'
  import AddTask from './add-task/Index.vue'
  import ListItem from './list-item/Index.vue'
  import Sortable from 'sortablejs'
  import { axios, cannot } from 'spack'
  import Menu from './Menu.vue'
  import Name from './Name.vue'

  const listItemsWrapper = ref<HTMLElement | null>(null)

  const { list } = defineProps<{
    list: any
    index: number
  }>()

  onMounted(() => {
    if (listItemsWrapper.value) {
      sortableInit()
    }
  })

  function onToggle(open: boolean, toggle: () => void) {
    toggle()

    if (!open) {
      setTimeout(() => {
        sortableInit()
      }, 100)
    }
  }

  function sortableInit() {
    if (cannot('task:move')) return

    Sortable.create(listItemsWrapper.value!, {
      group: 'shared',
      draggable: '.draggable-item',
      delay: 300, // time in milliseconds to define when the sorting should start
      delayOnTouchOnly: true, // only delay if user is using touch
      touchStartThreshold: 100, // px, how many pixels the point should move before cancelling a delayed drag event
      onUpdate: function (evt) {
        console.log('onUpdate task sort!!')
        console.log(evt.item)
        console.log(evt.item.getAttribute('data-id'))
        const id = evt.item.getAttribute('data-id')

        axios.patch(`/tasks/${id}/sort`, {
          id,
          project_id: list.project_id,
          old_index: (evt.oldIndex as number) + 1,
          new_index: (evt.newIndex as number) + 1,
        })
        // al.updateTaskListSort(evt.item.getAttribute('data-id'), evt.item.parentElement.getAttribute('data-id'), evt.oldIndex, evt.newIndex)

        // console.log(evt.item.parentElement.getAttribute('data-id'))
        // console.log(evt.item.getAttribute('data-id'))
      },
      onAdd: function (evt) {
        console.log('onAdd task new list!!')
        console.log(evt)
        console.log(evt.to)
        console.log(evt.item.getAttribute('data-id'))

        const id = evt.item.getAttribute('data-id')

        axios.patch(`/tasks/${id}/move`, {
          project_id: list.project_id,
          from_list: evt.from.getAttribute('data-id'),
          to_list: evt.to.getAttribute('data-id'),
          old_index: (evt.oldIndex as number) + 1,
          new_index: (evt.newIndex as number) + 1,
        })

        // al.updateTaskListSortOtherList(evt.item.getAttribute('data-id'), evt.from.getAttribute('data-id'), evt.to.getAttribute('data-id'), evt.oldIndex, evt.newIndex)
      },
    })
  }
</script>
