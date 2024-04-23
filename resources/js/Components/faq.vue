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
  <div class="p-6 bg-secondarybg flex flex-col md:justify-between relative my-2 rounded-md">
    <div class="mb-4 md:mb-0 md:mr-4 text-primarytext md:w-1/2 lg:w-2/3 xl:w-3/4 relative">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <p class="text-xl font-bold inline-block absolute left-0">
            {{ question }}
          </p>
          <button @click="toggleVisibility" class="absolute right-0 bg-inherit rounded-full p-2 inline focus:bg-buttonbg">
            {{ isVisible ? '-' : '+' }}
          </button>
          <div v-if="isVisible" class="block p-2">
            <p class="text-lg text-secondarytext">
              {{ answer }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>