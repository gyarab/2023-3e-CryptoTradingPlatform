<template>
  <div class="p-6 flex flex-col md:flex-row items-center md:justify-between relative">
    <div class="mb-4 md:mb-0 md:mr-4 text-white md:w-1/2 lg:w-2/3 xl:w-3/4">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <img class="w-24 mr-2 mt-2" :src="currencyImg" :alt="`${name} logo`"> <!-- Adjusted margin-top for the logo -->
          <div>
            <p class="text-xl md:text-2xl lg:text-3xl font-bold text-center md:text-left">{{ name }}</p>
            <p class="text-secondarytext text-sm md:text-base text-center md:text-left">({{ shortcut }})</p>
          </div>
        </div>
      </div>
      <div class="text-left">
        <p class="text-primarytext">Supply: <span class="font-bold text-lg">{{ parseFloat(supply).toFixed(3) }}</span></p>
        <p class="text-primarytext">Max Supply: <span class="font-bold text-lg">{{ parseFloat(maxSupply) }}</span></p>
        <p class="text-primarytext">Volume (24Hr): <span class="font-bold text-lg">{{ parseFloat(volumeUsd24Hr).toFixed(3) }}</span></p>
        <p class="text-primarytext">Change (24Hr): <span class="font-bold text-lg">{{ parseFloat(changePercent24Hr).toFixed(3) }} %</span></p>
        <p class="text-primarytext">VWAP (24Hr): <span class="font-bold text-lg">{{ parseFloat(vwap24Hr).toFixed(3) }}</span></p>
        <p class="text-primarytext">Value in USD: <span class="font-bold text-lg">${{ parseFloat(priceUsd).toFixed(3) }}</span></p>
      </div>
    </div>

    <button @click="addToMyList" class="absolute top-0 right-0 bg-green-500 text-white px-4 py-2 rounded-md mt-5 mr-6 transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">Add to My List</button> 

    <div class="text-primarytext md:w-1/2 lg:w-1/3 xl:w-1/4">
      <div class="mb-4 text-center md:text-left">
        <p class="text-secondarytext text-sm md:text-base">Buy 1 {{ name }}</p>
        <p class="text-2xl md:text-3xl font-bold"><span class="text-green-500">$</span>{{ parseFloat(priceUsd).toFixed(3) }}</p>
      </div>

      <button class="bg-buttonbg text-white px-4 py-2 rounded-md w-full transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">Buy Now</button>
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
