<template>
  <div class="p-6 bg-secondarybg flex flex-col md:flex-row items-center md:justify-between relative">
    <div class="mb-4 md:mb-0 md:mr-4 text-primarytext md:w-1/2 lg:w-2/3 xl:w-3/4">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <img class="w-12 mr-2 mt-2 sm:w-24" :src="currencyImg" :alt="`${cryptocurrencyName} logo`"> <!-- Adjusted margin-top for the logo -->
          <div>
            <p class="text-xl md:text-2xl lg:text-3xl font-bold text-center md:text-left text-primarytext">{{ cryptocurrencyName }}</p>
            <p class="text-gray-500 text-sm md:text-base text-center md:text-left">({{ shortcut }})</p>
          </div>
        </div>
      </div>
      <div class="text-left">
        <p class="text-primarytext">Supply: <span class="font-bold text-lg">{{ formatNumber(parseFloat(supply).toFixed(3)) }}  <span class="text-gray-400">{{ shortcut }}</span></span></p>
        <p v-if="maxSupply" class="text-primarytext">Max Supply: <span class="font-bold text-lg">{{ parseFloat(maxSupply) }} <span class="text-gray-400">{{ shortcut }}</span></span></p>
        <p class="text-primarytext">Volume (24Hr): <span class="font-bold text-lg">{{ formatNumber(parseFloat(volumeUsd24Hr).toFixed(3)) }} <span class="text-green-500"> $</span></span></p>
        <p class="text-primarytext">Change (24Hr): <span v-if="changePercent24Hr>0" class="font-bold text-lg text-green-500">{{ parseFloat(changePercent24Hr).toFixed(3) }} %</span> <span v-else class="font-bold text-lg text-red-500">{{ parseFloat(changePercent24Hr).toFixed(3) }} %</span></p>
        <p class="text-primarytext">VWAP (24Hr): <span class="font-bold text-lg">{{ parseFloat(vwap24Hr).toFixed(3) }}<span class="text-green-500"> $</span></span></p>
        <p class="text-primarytext">Value in USD: <span class="font-bold text-lg">{{ parseFloat(priceUsd).toFixed(3) }} <span class="text-green-500"> $</span></span></p>
      </div>
    </div>

    <AddToMyListButton :cryptocurrencyName="cryptocurrencyName" :addedToList="addedToList" />

    <div class="text-primarytext md:w-1/2 lg:w-1/3 xl:w-1/4">
        <div class="mb-4 text-center md:text-left">
          <p class="text-secondarytext text-sm md:text-base">Buy 1 {{ cryptocurrencyName }}</p>
          <p class="text-2xl md:text-3xl font-bold"><span class="text-green-500">$</span>{{ parseFloat(priceUsd).toFixed(3) }}</p>
        </div>

        <a :href="'/dashboard/' + cryptocurrencyName.toLowerCase() + '/buy'" class="bg-buttonbg text-white px-4 py-2 rounded-md block text-center transition duration-300 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none">BUY/SELL</a>
    </div>
  </div>
</template>
    

<script setup>
import AddToMyListButton from '@/Components/AddToMyListButton.vue';

defineProps({
  cryptocurrencyName: String,
  shortcut: String,
  priceUsd: String,
  supply: String,      
  maxSupply: String,
  volumeUsd24Hr: String,
  changePercent24Hr: String,
  vwap24Hr: String,
  currencyImg: String,
  addedToList: Boolean,
});
</script>
<script>
export default {
  data() {
    return {};
  },
  methods: {
    //THIS METHOD WAS CREATED BY CHATGPT
    formatNumber(number) {
      // Convert number to string
      let numberString = number.toString();
      // Remove trailing zeros and decimal point if all decimal places are zeros
      let formattedString = numberString.replace(/(\.[0-9]*[1-9])0+$|\.0*$/, '$1');
      // Insert a space after every three numeric characters from the end
      formattedString = formattedString.replace(/\d{1,3}(?=(\d{3})+(?!\d))/g, '$& ');
      return formattedString;
    }
  },
};
</script>
