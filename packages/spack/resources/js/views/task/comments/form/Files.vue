<template>
  <ul v-if="files.length" class="mx-3 mb-1 mt-1 divide-y rounded-md border">
    <li v-for="(file, fileIndex) in files" :key="file.name" class="block px-3 py-2">
      <div class="flex items-center">
        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
          <path
            fill-rule="evenodd"
            d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
            clip-rule="evenodd"
          />
        </svg>
        <span class="w-0 flex-1 truncate text-sm ltr:ml-2 rtl:mr-2">
          {{ file.name }}
        </span>
        <span class="cursor-pointer ltr:ml-auto rtl:mr-auto" @click="removeFile(fileIndex)">
          <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
            />
          </svg>
        </span>
      </div>

      <div v-if="progress[fileIndex] && progress[fileIndex]['progress'] !== 100" class="mt-2 w-full rounded-md bg-green-100">
        <span
          class="block h-1 rounded-md"
          :class="{'bg-green-500': progress[fileIndex]['success'], 'bg-red-500': progress[fileIndex]['failed']}"
          :style="{ width: progress[fileIndex]['progress'] + '%' }"
        />
      </div>
    </li>
  </ul>
</template>

<script setup lang="ts">
  import { useCommentForm } from 'Use/comment/form'

  const { files, progress, removeFile } = useCommentForm()
</script>
