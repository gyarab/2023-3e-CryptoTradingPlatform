<script setup>
defineProps({
    question: String,
    answer: String,
})
</script>

<script>
export default {
  data() {
    return {
      isVisible: false // Initially, the div is hidden
    };
  },
  methods: {
    toggleVisibility() {
      // Toggle the visibility state of the div
      this.isVisible = !this.isVisible;
    }
  }
}
</script>

<template>
<div class="p-6 bg-secondarybg flex flex-col md:justify-between my-2 rounded-md w-full shadow-md">
  <div class="text-primarytext relative">
    <div class="flex items-center justify-between">
      <div class="flex items-center w-full">
        <p class="text-xl font-bold inline-block mr-2">
          {{ question }}
        </p>
        <button @click="toggleVisibility" class="bg-inherit rounded-full p-2 inline-flex items-center justify-center focus:bg-buttonbg font-bold text-xl ml-auto transition-all" style="width: 2.5rem; height: 2.5rem;">
          {{ isVisible ? '-' : '+' }}
        </button>
      </div>
    </div>
    <div v-if="isVisible" class="p-2 mt-4">
      <p class="text-lg text-secondarytext block ml-2">
        {{ answer }}
      </p>
    </div>
  </div>
</div>
</template>