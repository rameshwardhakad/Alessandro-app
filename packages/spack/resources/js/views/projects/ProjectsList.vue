<template>
  <ul ref="ul" class="divide-y rounded-lg bg-white py-0 shadow">
    <li
      v-for="(item, index) in store.items"
      :key="item.id"
      class="flex items-center px-6 py-3"
      :data-id="item.id"
    >
      <!-- <span class="drag-handle cursor-grab">
        <Bars2Icon class="h-4 w-4 text-gray-500 hover:text-gray-800" />
      </span> -->

      <RouterLink class="group flex flex-1 items-center" :to="'/projects/' + item.id">
        <span
          class="block h-2 w-2 flex-shrink-0 rounded-full"
          :style="{ 'background-color': item.meta.color }"
        />
        <span class="truncate text-gray-500 group-hover:text-gray-900 ltr:ml-3 rtl:mr-3">
          {{ item.name }}
        </span>
      </RouterLink>

      <div class="ltr:ml-auto rtl:mr-auto">
        <ProjectArchive v-if="can('project:archive')" :id="item.id" :index="index" />
      </div>
    </li>
  </ul>
</template>

<script setup lang="ts">
  import { onMounted, ref } from 'vue'
  import Sortable from 'sortablejs'
  import { useProjectIndexStore } from 'Store/project-index'
  import ProjectArchive from './ProjectArchive.vue'

  const ul = ref<HTMLInputElement | null>(null)
  const store = useProjectIndexStore()

  onMounted(() => {
    var sortable = Sortable.create(ul.value!, {
      // var sortable = new Sortable(ul.value!, {
      handle: '.drag-handle', // Drag handle selector within list items
      // ghostClass: 'our-ghost', // Class name for the drop placeholder
      // chosenClass: 'bg-white', // Class name for the chosen item
      // dragClass: 'bg-yellow-200', // Class name for the dragging item
      // swapThreshold: 1, // Threshold of the swap zone
      // invertSwap: false, // Will always use inverted swap zone if set to true
      // invertedSwapThreshold: 1, // Threshold of the inverted swap zone (will be set to swapThreshold value by default)
      // direction: 'horizontal', // Direction of Sortable (will be detected automatically if not given)
      // forceFallback: true, // ignore the HTML5 DnD behaviour and force the fallback to kick in

      // Changed sorting within list
      onUpdate: function (/**Event*/ evt) {
        // same properties as onEnd
        console.log(evt.item)
        console.log(evt.item.getAttribute('data-id'))
        console.log('onUpdate', evt)
        store.sort(parseInt(evt.item.getAttribute('data-id') as string), evt.newIndex as number)
      },
    })

    console.log(sortable)
  })
</script>
