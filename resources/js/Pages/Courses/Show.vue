<script setup lang="ts">
import type { Course, LessonContent } from '@/types'
import IconClock from 'virtual:icons/heroicons/clock'
import IconDocumentText from 'virtual:icons/heroicons/document-text'
import IconVideoCamera from 'virtual:icons/heroicons/video-camera'

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

    <div
      class="grid-cols-course max-md:grid-cols-1 grid gap-10 py-12 items-start lg:max-w-7xl mx-auto px-6 lg:px-8"
    >
      <div class="order-3 md:order-1 flex flex-col gap-4 p-6 lg:p-8 bg-white dark:bg-gray-800 overflow-hidden shadow-lg dark:shadow-gray-900 rounded-lg">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
          {{ course.title }}
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
          Created by <u>{{ course.creator.name }}</u>
        </p>
        <div class="flex items-center gap-1">
          <IconClock class="text-gray-600 dark:text-gray-400" />
          <span class="text-xs md:text-sm text-gray-600 dark:text-gray-400">
            {{ course.duration }}
          </span>
        </div>
        <hr class="border-gray-200 dark:border-gray-700 bg-opacity-25">
        <div class="mb-2">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
            Description
          </h2>
          <p class="mt-1 text-gray-600 dark:text-gray-400">
            {{ course.description }}
          </p>
        </div>
        <div>
          <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
            Lessons
          </h2>
          <div class="mt-1 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 rounded-lg">
            <details
              v-for="lesson in course.lessons" :key="lesson.id"
              class="px-3 py-3  border-b border-b-gray-200 dark:border-b-gray-700"
            >
              <summary class="cursor-pointer flex gap-2 items-center justify-between">
                <span class="text-gray-900 dark:text-gray-100">
                  {{ lesson.title }}
                </span>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                  {{ lesson.duration }}
                </span>
              </summary>

              <div class="ps-4 pt-4 space-y-4">
                <p class="italic" v-html="lesson.meta_description" />

                <div>
                  <h3 class="text-md font-semibold text-gray-900 dark:text-gray-100">
                    Duration
                  </h3>
                  <div class="pl-2 flex gap-2 items-center">
                    <IconClock class="text-gray-600 dark:text-gray-400" />
                    <span class="text-sm">
                      {{ lesson.duration }}
                    </span>
                  </div>
                </div>

                <div>
                  <h3 class="text-md font-semibold text-gray-900 dark:text-gray-100">
                    Content
                  </h3>
                  <ul class="pl-2">
                    <li
                      v-for="content in lesson.contents" :key="content.id"
                      class="flex gap-2 items-center py-2"
                    >
                      <IconVideoCamera v-if="content.type === 'video'" />
                      <IconDocumentText v-else-if="content.type === 'text'" />
                      <span>{{ content.data.title }}</span>
                    </li>
                  </ul>
                </div>
              </div>
            </details>
          </div>
        </div>
      </div>
      <div class="order-2 md:sticky md:top-[6.25rem] flex flex-col gap-4 p-6 lg:p-8 bg-white dark:bg-gray-800 overflow-hidden shadow-lg dark:shadow-gray-900 rounded-lg">
        <img
          class=" rounded-lg w-full h-full max-h-40 sm:max-h-60 md:max-h-56 object-cover"
          :src="course.media.url"
          :alt="course.media.alt"
        >

        <h1 class="mt-4 text-3xl font-semibold text-gray-900 dark:text-gray-100">
          {{ course.is_free ? 'Free' : course.price }}
        </h1>

        <PrimaryButton class="justify-center">
          {{ course.is_free ? 'Enroll Yourself' : 'Buy Course' }}
        </PrimaryButton>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.grid-cols-course {
  grid-template-columns: minmax(0, 1fr);
}

@media (min-width: 768px) {
  .grid-cols-course {
    grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
}
}
</style>
