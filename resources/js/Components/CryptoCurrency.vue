<template>
  <div class="p-6 flex flex-col md:flex-row items-center md:justify-between relative">
    <!-- Left Section: Crypto Information -->
    <div class="mb-4 md:mb-0 md:mr-4 text-white md:w-1/2 lg:w-2/3 xl:w-3/4">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <img class="w-24 mr-2 mt-2" :src="currencyImg" :alt="`${name} logo`"> <!-- Adjusted margin-top for the logo -->
          <div>
            <p class="text-xl md:text-2xl lg:text-3xl font-bold text-center md:text-left">{{ name }}</p>
            <p class="text-gray-500 text-sm md:text-base text-center md:text-left">({{ shortcut }})</p>
          </div>
        </div>
      </div>
      <div class="text-left">
        <p class="text-primarytext">Supply: <span class="font-bold text-lg">{{ supply }}</span></p>
        <p class="text-primarytext">Max Supply: <span class="font-bold text-lg">{{ maxSupply }}</span></p>
        <p class="text-primarytext">Volume (24Hr): <span class="font-bold text-lg">{{ volumeUsd24Hr }}</span></p>
        <p class="text-primarytext">Change (24Hr): <span class="font-bold text-lg">{{ changePercent24Hr }}</span></p>
        <p class="text-primarytext">VWAP (24Hr): <span class="font-bold text-lg">{{ vwap24Hr }}</span></p>
        <p class="text-primarytext">Value in USD: <span class="font-bold text-lg">${{ parseFloat(priceUsd).toFixed(3) }}</span></p>
      </div>
    </div>

    <!-- Add to My List Button (positioned at the top-right corner) -->
    <button @click="addToMyList" class="absolute top-0 right-0 bg-green-500 text-white px-4 py-2 rounded-md mt-5 mr-6 transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">Add to My List</button> <!-- Adjusted margin-top and margin-right -->

    <!-- Right Section: Buy Bitcoin -->
    <div class="text-white md:w-1/2 lg:w-1/3 xl:w-1/4">
      <div class="mb-4 text-center md:text-left">
        <p class="text-gray-600 text-sm md:text-base">Buy 1 {{ name }}</p>
        <p class="text-2xl md:text-3xl font-bold">${{ parseFloat(priceUsd).toFixed(3) }}</p>
      </div>

      <!-- Buy Now Button -->
      <button class="bg-purple-500 text-white px-4 py-2 rounded-md w-full transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">Buy Now</button>
    </div>
  </div>
</template>
    

<script setup>
defineProps({
  name: String,
  shortcut: String,
  priceUsd: String,
  supply: String,      
  maxSupply: String,
  volumeUsd24Hr: String,
  changePercent24Hr: String,
  vwap24Hr: String,
  currencyImg: String,
});
</script>
