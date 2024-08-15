<template>
  <Form v-if="isForm" />

  <Skelton v-else />
</template>

<script setup lang="ts">
  import { useCommentForm } from 'Use/comment/form'
  import Form from './Form.vue'
  import Skelton from './Skelton.vue'

  const { isForm } = useCommentForm()
</script>
