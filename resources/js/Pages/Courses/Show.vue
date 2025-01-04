<script setup lang="ts">
import type { Course, User } from '@/types'
import { router } from '@inertiajs/vue3'
import IconCheckCircle from 'virtual:icons/heroicons/check-circle'
import IconClock from 'virtual:icons/heroicons/clock'
import IconDocumentText from 'virtual:icons/heroicons/document-text'
import IconVideoCamera from 'virtual:icons/heroicons/video-camera'

const props = defineProps<{
  course: Course
  auth: {
    user: User
  }
}>()

const isCourseEnrolled = computed(() =>
  props.auth.user.enrolled_courses.includes(props.course.slug),
)

function computeContentUrl(contentId: number) {
  return route('courses.show.content', {
    course: props.course.slug,
    content: contentId,
  })
}
</script>

<template>
  <AppLayout :title="course.title">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Course: {{ course.title }}
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
              class="last:border-b-0 border-b border-b-gray-200 dark:border-b-gray-700"
            >
              <summary class="px-3 py-3 cursor-pointer flex gap-2 items-center justify-between">
                <span class="text-gray-900 dark:text-gray-100">
                  {{ lesson.title }}
                </span>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                  {{ lesson.duration }}
                </span>
              </summary>

              <div class="p-4 space-y-4">
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
                      :class="{
                        'hover:underline': isCourseEnrolled,
                      }"
                    >
                      <component
                        :is="isCourseEnrolled ? 'Link' : 'div'"
                        :href="isCourseEnrolled ? computeContentUrl(content.id) : undefined"
                        class="contents"
                      >
                        <IconVideoCamera v-if="content.type === 'video'" />
                        <IconDocumentText v-else-if="content.type === 'text'" />
                        <span>{{ content.data.title }}</span>
                      </component>
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

        <div class="mt-4 flex gap-2 items-center">
          <h1
            class="text-3xl font-semibold text-gray-900 dark:text-gray-100"
            :class="{
              'line-through opacity-50': isCourseEnrolled && !course.is_free,
            }"
          >
            {{ course.is_free ? 'Free' : course.price }}
          </h1>
          <IconCheckCircle v-if="isCourseEnrolled" class="w-7 h-7 dark:text-green-400 text-green-500" />
        </div>
        <PrimaryButton
          class="justify-center"
          :disabled="isCourseEnrolled"
          @click="router.post(route('courses.enroll', {
            course: course.slug,
          }))"
        >
          {{
            isCourseEnrolled
              ? 'Enrolled'
              : course.is_free ? 'Enroll Yourself' : 'Buy Course'
          }}
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
