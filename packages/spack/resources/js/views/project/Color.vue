<template>
  <Dropdown close-outside>
    <template #trigger>
      <div class="h-7 w-7 cursor-pointer rounded p-[0.563rem] hover:bg-gray-200">
        <p class="h-2.5 w-2.5 rounded-full" :style="{ 'background-color': project.meta.color }">
          &nbsp;
        </p>
      </div>
    </template>

    <template #content>
      <div class="dropdown-card w-[17rem]">
        <div class="flex flex-wrap gap-2 p-3">
          <label
            v-for="option in project.colorOptions"
            :key="option.value"
            class="inline-block h-6 w-6 cursor-pointer rounded"
            :style="{
              'background-color': option.value as string,
              color: project.meta.color == option.value ? '#ffffff' : (option.value as string),
            }"
          >
            <svg viewBox="0 0 16 16" fill="currentColor">
              <path
                d="M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z"
              />
            </svg>

            <input
              v-model="project.meta.color"
              type="radio"
              class="hidden"
              :value="option.value"
              @change="onColorChange"
            />
          </label>
        </div>
      </div>
    </template>
  </Dropdown>
</template>

<script setup lang="ts">
  import { useProjectDetailStore } from 'Store/project-detail'
  import { Dropdown } from 'thetheme'

  const { onColorChange, project } = useProjectDetailStore()
</script>
