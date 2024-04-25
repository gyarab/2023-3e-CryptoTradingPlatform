<template>
  <transition name="slide-fade">
    <button v-if="!addedToList" @click="addToMyList(cryptocurrencyName)"
      class="absolute top-0 right-0 bg-green-500 text-white px-4 py-2 rounded-md mt-5 mr-6 transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">
      <span v-if="!showDone" class="animate-pulse">Add to My List</span>
      <span v-else>Added ✓</span>
    </button>
    <button v-else @click="removeFromMyList(cryptocurrencyName)"
      class="absolute top-0 right-0 bg-gray-500 text-white px-4 py-2 rounded-md mt-5 mr-6 transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">
      <span v-if="!showDone">Remove from My List</span>
      <span v-else>Removed ✕</span>
    </button>
  </transition>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import axios from 'axios';

defineProps({
  cryptocurrencyName: String,
  addedToList: Boolean,
});

const showDone = ref(false);

const addToMyList = async (cryptocurrencyName) => {
  try {
    // Show the done symbol
    showDone.value = true;
    await axios.post('/add-to-my-list', { cryptocurrencyName });
    console.log({ cryptocurrencyName }, 'Cryptocurrency added to your list successfully!');
  } catch (error) {
    console.error('Failed to add cryptocurrency to your list:', error);
  }
};

const removeFromMyList = async (cryptocurrencyName) => {
  try {
    // Show the done symbol
    showDone.value = true;
    await axios.post('/remove-from-my-list', { cryptocurrencyName });
    console.log({ cryptocurrencyName }, 'Cryptocurrency removed from your list successfully!');
  } catch (error) {
    console.error('Failed to remove cryptocurrency from your list:', error);
  }
};
</script>

<style>
/* ChatGPT(generate a simple pulse button animation) */
.button-add-remove {
  position: relative;
}

.animate-pulse {
  animation: pulse 1.5s infinite;
}

@keyframes pulse {
  0% {
    opacity: 0.5;
  }

  50% {
    opacity: 1;
  }

  100% {
    opacity: 0.5;
  }
}
</style>