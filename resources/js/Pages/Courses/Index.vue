<script setup lang="ts">
import type { Course } from '@/types'
import IconArrowRight from 'virtual:icons/heroicons/arrow-right-16-solid'
import IconClock from 'virtual:icons/heroicons/clock'

defineProps<{
  courses: Course[]
}>()
</script>

<template>
  <AppLayout title="Courses">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Courses
      </h2>
    </template>

    <div class="py-12 max-w-md md:max-w-4xl lg:max-w-7xl mx-auto px-6 sm:px-8 md:px-10">
      <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        <li
          v-for="course in courses" :key="course.id"
          class="group hover:cursor-pointer flex flex-col p-4 lg:p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-lg dark:shadow-gray-900 rounded-lg"
        >
          <img class="group-hover:scale-[102%] group-hover:shadow-lg group-hover:shadow-gray-300 dark:group-hover:shadow-gray-900 transition rounded-lg w-full h-full max-h-40 sm:max-h-60 md:max-h-56 object-cover" :src="course.media.url" :alt="course.media.alt">
          <div class="mt-4 =">
            <hgroup class="flex items-center gap-1">
              <h2 class="group-hover:underline text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{ course.title }}
              </h2>
              <IconArrowRight class="transition opacity-0 group-hover:opacity-100" />
            </hgroup>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
              {{ course.meta_description }}
            </p>
          </div>
          <div class="flex-grow mt-4 flex items-end">
            <div class="flex justify-between items-center w-full gap-2">
              <div class="flex items-center gap-2">
                <img
                  :alt="`Creator Avatar - ${course.creator.name}`"
                  :src="`${course.creator.profile_photo_url}`"
                  class="h-6 w-6 md:h-8 md:w-8 rounded-lg object-cover"
                >
                <span class="font-bold">
                  {{ course.creator.name }}
                </span>
              </div>

              <div class="flex items-center gap-1">
                <IconClock class="text-gray-600 dark:text-gray-400" />
                <span class="text-xs md:text-sm text-gray-600 dark:text-gray-400">
                  {{ course.duration }}
                </span>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </AppLayout>
</template>
