<template>
  <form @submit.prevent="redirectToUserInput">
    <div class="flex items-center text-primarytext">
      <input
        class="placeholder:text-primarytext p-4 border rounded-md mr-2 w-full bg-bg"
        type="text"
        v-model="searchValue"
        placeholder="Search for Crypto..."
      />
      <PrimaryButton type="submit" class="p-4 py-4">
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
      </PrimaryButton>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
