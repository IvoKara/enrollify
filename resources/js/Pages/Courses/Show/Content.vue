<script setup lang="ts">
import type { LessonContent } from '@/types'

defineProps<{
  content: LessonContent
  course_slug: string
}>()
</script>

<template>
  <AppLayout :title="content.data.title">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ content.data.title }}
      </h2>
    </template>

    <div
      class="py-12 items-start lg:max-w-5xl mx-auto px-6 lg:px-8"
    >
      <div class="mb-4">
        <Link :href="route('courses.show', course_slug)">
          <SecondaryButton>Go back to Course</SecondaryButton>
        </Link>
      </div>
      <div class="flex flex-col gap-4 p-6 lg:p-8 bg-white dark:bg-gray-800 overflow-hidden rounded-lg">
        <img
          v-if="content.type === 'text' && content.data.media"
          class="mb-10 rounded-lg w-full h-full object-cover"
          :src="content.data?.media.url"
          :alt="content.data.media.alt"
        >

        <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
          {{ content.data.title }}
        </h1>

        <span class="text-gray-600 dark:text-gray-400">
          Lesson: {{ content.lesson.title }}
        </span>

        <span v-if="content.type === 'text'" class="text-sm text-gray-600 dark:text-gray-400">
          Read duration: {{ content.data.duration }}
        </span>

        <iframe
          v-if="content.type === 'video'"
          width="100%" height="500"
          class="rounded-lg"
          :src="`https://www.youtube.com/embed/${content.data.url_id}`"
          frameborder="0"
          allow="autoplay; encrypted-media" allowfullscreen
        />

        <article
          v-html="
            content.type === 'text'
              ? content.data.content
              : content.data.description
          "
        />
      </div>
      <div class="mt-10 flex items-center justify-center gap-10">
        <Link
          v-if="content.prev_id"
          :href="route('courses.show.content', {
            course: course_slug,
            content: content.prev_id,
          })"
        >
          <PrimaryButton>
            Previous
          </PrimaryButton>
        </Link>
        <Link
          v-if="content.next_id"
          :href="route('courses.show.content', {
            course: course_slug,
            content: content.next_id,
          })"
        >
          <PrimaryButton>
            Next
          </PrimaryButton>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
