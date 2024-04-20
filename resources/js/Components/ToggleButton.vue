<template>
    <transition name="slide-fade">
      <button @click="toggle()" class="bg-green-500 text-white px-4 py-2 rounded-md mt-5 mr-6 transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">
        <span v-if="!showDone" class="animate-pulse">{{textBefore}}</span>
        <span v-else>{{textAfter}}✓</span>
      </button>
    </transition>
  </template>
  
  <script setup>
  import { defineProps, ref } from 'vue';
  
  defineProps({
    textBefore: String,
    textAfter: String,
  });
  
  const showDone = ref(false);
  
  const toggle = async () => {
    showDone.value = true;
    // After 2 seconds, reset showDone to false
    setTimeout(() => {
      showDone.value = false;
    }, 2000);
  };
  </script>
  
  <style>
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
  