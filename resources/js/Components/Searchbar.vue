<template>
  <form @submit.prevent="redirectToUserInput">
    <div class="flex items-center">
      <input
        type="text"
        v-model="searchValue"
        placeholder="Search for Crypto..."
        class="p-4 border rounded-md mr-2 w-full"
      />
      <button type="submit" class="p-4 bg-purple-500 text-white rounded-md">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          class="h-6 w-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          ></path>
        </svg>
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';

const searchValue = ref('');

const redirectToUserInput = () => {
  const isString = /^[A-Za-z]+$/.test(searchValue.value);

  if (!isString) {
    // If it's not a string, redirect to the dashboard
    window.location.href = '/dashboard';
    return;
  }

  const targetUrl = searchValue.value ? `/dashboard/${searchValue.value}` : '/dashboard';
  console.log('Redirecting to:', targetUrl);
  window.location.href = targetUrl;
};
</script>
