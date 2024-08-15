<template>
  <div class="space-y-4">
    <template v-for="(comment, index) in comments" :key="comment.id">
      <Component
        :is="false ? 'CommentForm' : CommentItem"
        :id="comment.id"
        :index="index"
        :comment="comment"
      />
    </template>
  </div>
</template>

<script setup lang="ts">
  import { useTaskState } from 'Use/task'
  import CommentItem from './CommentItem.vue'

  const { comments } = useTaskState()
</script>
