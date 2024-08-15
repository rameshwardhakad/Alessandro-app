<template>
  <div class="space-y-4">
    <div v-for="(comment, index) in comments" :key="comment.id" class="group relative flex py-1">
      <div class="h-6 w-6">
        <UserAvatar class="h-6 w-6" :avatar="comment.user.avatar" />
      </div>
      <div class="group flex-1 ltr:pl-4 rtl:pr-4">
        <div class="flex">
          <h2 class="flex text-sm font-medium leading-none text-gray-700">
            {{ comment.user.name }}
            <span class="text-xs font-normal text-gray-500 ltr:ml-3 rtl:mr-3">
              {{ comment.updated_at }}
            </span>
          </h2>
        </div>

        <!-- eslint-disable vue/no-v-html -->
        <p
          class="prose prose-sm mt-1.5 break-all text-sm text-gray-600"
          v-html="marked.parse(comment.text || '', { breaks: true, renderer })"
        ></p>
        <!--eslint-enable-->

        <ul v-if="comment.attachments.length" class="mb-1 mt-4 divide-y rounded-md border">
          <li
            v-for="attachment in comment.attachments"
            :key="attachment.name"
            class="flex items-center px-3 py-2"
          >
            <div class="flex flex-1 items-center">
              <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path
                  fill-rule="evenodd"
                  d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                  clip-rule="evenodd"
                />
              </svg>
              <a
                :href="'/' + attachment.path"
                class="block w-0 flex-1 truncate text-xs text-gray-700 hover:underline ltr:ml-2 ltr:pr-2 rtl:mr-2 rtl:pl-2"
                target="blank"
              >
                {{ attachment.name }}
              </a>
            </div>
            <a :href="'/' + attachment.path" class="ltr:ml-auto rtl:mr-auto" target="blank">
              <ArrowDownTrayIcon class="h-5 w-5 text-gray-400" />
            </a>
          </li>
        </ul>
      </div>

      <CommentDelete :index="index" :comment="comment" />

      <!-- <div class="w-4" v-if="config.user.id == comment.author_id">
        <span @click="onDelete(comment.id, index)">
          <TrashIcon class="w-4 h-4 text-gray-500 hover:text-gray-800 cursor-pointer"/>
        </span>
      </div> -->
    </div>
  </div>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'
  import { marked } from 'marked'
  import { UserAvatar } from 'thetheme'
  import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline'
  import CommentDelete from './Delete.vue'

  const { comments } = useTaskState()

  const renderer = new marked.Renderer()
  const linkRenderer = renderer.link
  renderer.link = (href, title, text) => {
    const html = linkRenderer.call(renderer, href, title, text)
    return html.replace(/^<a /, `<a target="_blank" rel="noreferrer noopener nofollow" `)
  }
</script>
