<script setup lang="ts">
import type { Course, LessonContent } from '@/types'

defineProps<{
  course: Course
}>()
</script>

<template>
  <AppLayout :title="course.title">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ course.title }}
      </h2>
    </template>

    <pre>
      {{ course }}
    </pre>
  </AppLayout>
</template>
