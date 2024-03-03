<template>
    <div class="p-6 flex flex-col md:flex-row items-start md:justify-between">
      <!-- Left Section: Crypto Information -->
      <div class="mb-4 md:mb-0 md:mr-4 text-white">
        <div class="flex items-center mb-4">
          <img class="w-24 mr-2" :src="currencyImg" :alt="`${name} logo`">
          <div>
            <p class="text-2xl font-bold">{{ name }}</p>
            <p class="text-gray-500">({{ shortcut }})</p>
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
  
      <!-- Right Section: Buy Bitcoin -->
      <div class="text-white">
        <div class="mb-4">
          <p class="text-gray-600">Buy Bitcoin</p>
          <p class="text-2xl font-bold">${{ parseFloat(priceUsd).toFixed(3) }}</p>
        </div>
        <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Buy Now</button>
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
