<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ApplicationName from '@/Components/ApplicationName.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-bg">
    <div class="flex flex-col items-center sm:flex-row sm:items-center">
      <Link href="/" class="ml-4 sm:ml-0 mb-4 sm:mb-0">
      <ApplicationLogo class="w-40 sm:w-80 fill-current text-gray-500" />
      </Link>
      <ApplicationName />
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-secondarybg shadow-md overflow-hidden sm:rounded-lg">
      <slot />
    </div>
  </div>
</template>