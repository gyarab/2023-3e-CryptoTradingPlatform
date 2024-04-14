<template>
    <transition name="slide-fade">
      <button v-if="!addedToList" @click="addToMyList(cryptocurrencyName)" class="absolute top-0 right-0 bg-green-500 text-white px-4 py-2 rounded-md mt-5 mr-6 transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">Add to My List {{ addedToList }}</button>
      <button v-else @click="removeFromMyList(cryptocurrencyName)" class="absolute top-0 right-0 bg-gray-500 text-white px-4 py-2 rounded-md mt-5 mr-6 transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">Remove from My List</button>
    </transition>
</template>
  
  <script setup>
  import { defineProps } from 'vue';
  import axios from 'axios';
  
  defineProps({
    cryptocurrencyName: String,
    addedToList: Boolean,
  });
  
  const addToMyList = async (cryptocurrencyName) => {
    try {
      await axios.post('/add-to-my-list', { cryptocurrencyName });
      console.log({ cryptocurrencyName }, 'Cryptocurrency added to your list successfully!');
    } catch (error) {
      console.error('Failed to add cryptocurrency to your list:', error);
    }
  };
  
  const removeFromMyList = async (cryptocurrencyName) => {
    try {
      await axios.post('/remove-from-my-list', { cryptocurrencyName });
      console.log({ cryptocurrencyName }, 'Cryptocurrency removed from your list successfully!');
    } catch (error) {
      console.error('Failed to remove cryptocurrency from your list:', error);
    }
  };
  </script>
  
  <style scoped>
  .slide-fade-enter-active, .slide-fade-leave-active {
    transition: opacity 0.5s, transform 0.5s;
  }
  .slide-fade-enter, .slide-fade-leave-to /* .slide-fade-leave-active in <2.1.8 */ {
    opacity: 0;
    transform: translateY(-20px);
  }
  </style>
  