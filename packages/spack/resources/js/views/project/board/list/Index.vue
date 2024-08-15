<template>
  <div
    class="draggable-item box-border inline-block h-full w-72 whitespace-nowrap rounded pb-4 align-top text-base ltr:mr-4 ltr:last:mr-0 rtl:ml-4 rtl:last:ml-0"
    :data-id="list.id"
    :class="{
      'opacity-50': list.id == 0,
      'pointer-events-none': list.id == 0,
    }"
  >
    <div class="box-border flex max-h-full flex-col whitespace-normal rounded-xl bg-gray-200">
      <div class="flex gap-x-1 p-2">
        <Name :id="list.id" :index="index" :name="list.name" />

        <ListMenu v-if="can('project-list:delete')" :id="list.id" :index="index" />
      </div>
      <div ref="cardWrapper" class="min-h-0 overflow-y-auto px-2">
        <div ref="cardsListWrapper" class="cards pb-0.5" :data-id="list.id">
          <ListCard
            v-for="task in list.tasks"
            :key="'task-card' + task.id"
            class="draggable-card"
            :task="task"
          />
        </div>

        <AddTaskForm v-if="isAddTaskForm == index" :index="index" @after-add="afterAddTask" />
      </div>
      <div v-if="cannot('task:create')" class="my-2 h-2">
        &nbsp;
      </div>
      <div v-if="isAddTaskForm != index && can('task:create')">
        <AddTaskButton @click="showForm(index)" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { onMounted, ref } from 'vue'
  import { useList } from 'Use/list'
  import ListMenu from './ListMenu.vue'
  import ListCard from './ListCard.vue'
  import Name from './Name.vue'
  import AddTaskForm from './AddTaskForm.vue'
  import AddTaskButton from './AddTaskButton.vue'
  import Sortable from 'sortablejs'
  import { axios, cannot } from 'spack'

  const props = defineProps<{
    list: any
    index: number
  }>()

  const cardWrapper = ref<HTMLElement | null>(null)
  const cardsListWrapper = ref<HTMLElement | null>(null)

  const { isAddTaskForm } = useList()

  onMounted(() => {
    if (cannot('task:move')) return

    Sortable.create(cardsListWrapper.value!, {
      group: 'shared',
      draggable: '.draggable-card',
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
          project_id: props.list.project_id,
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
          project_id: props.list.project_id,
          from_list: evt.from.getAttribute('data-id'),
          to_list: evt.to.getAttribute('data-id'),
          old_index: (evt.oldIndex as number) + 1,
          new_index: (evt.newIndex as number) + 1,
        })

        // al.updateTaskListSortOtherList(evt.item.getAttribute('data-id'), evt.from.getAttribute('data-id'), evt.to.getAttribute('data-id'), evt.oldIndex, evt.newIndex)
      },
    })
  })

  function showForm(index: number) {
    isAddTaskForm.value = index

    setTimeout(() => {
      console.log('hit setTimeout')
      console.log(cardWrapper.value)
      cardWrapper.value!.scrollTop = cardWrapper.value!.scrollHeight
    })
  }

  function afterAddTask() {
    cardWrapper.value!.scrollTop = cardWrapper.value!.scrollHeight
  }
</script>
