<script setup lang="ts">
defineProps({
  terms: String,
})
</script>

<template>
  <Head title="Terms of Service" />

  <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
    <div class="pt-20 bg-gray-100 dark:bg-gray-950">
      <div class="min-h-screen flex flex-col items-center gap-10 pt-6 sm:pt-0">
        <div>
          <AuthenticationCardLogo />
        </div>

        <Link href="/" class="hover:underline">
          Go back to homepage
        </Link>

        <div class="w-full sm:max-w-2xl p-6 bg-white dark:bg-gray-900 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert" v-html="terms" />
      </div>
    </div>
  </div>
</template>
