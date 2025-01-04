<script setup lang="ts">
defineProps({
  policy: String,
})
</script>

<template>
  <Head title="Privacy Policy" />

  <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
    <div class="pt-20 bg-gray-100 dark:bg-gray-950">
      <div class="min-h-screen flex flex-col items-center pt-6 gap-10 sm:pt-0">
        <div>
          <AuthenticationCardLogo />
        </div>

        <Link href="/" class="hover:underline">
          Go back to homepage
        </Link>

        <div class="w-full sm:max-w-2xl p-6 bg-white dark:bg-gray-900 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert" v-html="policy" />
      </div>
    </div>
  </div>
</template>
