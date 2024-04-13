<template>
  <div class="max-w-lg mx-auto mt-6 p-4 bg-white shadow-md rounded-lg">
    <label for="usdAmount" class="block text-sm font-medium text-gray-700">Amount in USD:</label>
    <input type="number" id="usdAmount" v-model.number="usdAmount" @input="updateCryptoAmount"
           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

    <label for="cryptoAmount" class="block mt-2 text-sm font-medium text-gray-700">Equivalent Amount:</label>
    <input type="text" id="cryptoAmount" :value="formattedCryptoAmount" readonly
           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
  </div>
</template>
<script>
import { watchEffect } from 'vue'; // Import watchEffect from Vue

export default {
  data() {
    return {
      usdAmount: 0,
    };
  },
  props: {
    exchangeRate: {
      type: Number,
      required: true,
    },
  },
  computed: {
    formattedCryptoAmount() {
      const cryptoAmount = this.usdAmount / this.exchangeRate;
      return cryptoAmount.toFixed(8);
    },
  },
  methods: {
    updateCryptoAmount() {
      // No need to handle NaN or infinite values here
      // Calculate cryptocurrency amount based on exchange rate and USD amount
      // Update the computed property to display the formatted amount

      // Emit the cryptoAmount whenever it changes
      this.$emit('cryptoAmountChanged', parseFloat(this.formattedCryptoAmount));
    },
  },
  mounted() {
    // Use watchEffect to watch the formattedCryptoAmount and emit whenever it changes
    watchEffect(() => {
      this.$emit('cryptoAmountChanged', parseFloat(this.formattedCryptoAmount));
    });
  },
};
</script>


  
  