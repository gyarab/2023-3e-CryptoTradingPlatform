<template>
  <div class="max-w-lg mx-auto mt-6 p-4 bg-secondarybg shadow-md rounded-lg">
    <!-- Buttons for Buy and Sell -->
    <div class="flex justify-between mb-4">
      <button class="px-4 py-2 bg-blue-500 text-white rounded-md" :class="{ 'bg-blue-600': mode === 'buy' }" @click="setMode('buy')">Buy</button>
      <button class="px-4 py-2 bg-red-500 text-white rounded-md" :class="{ 'bg-red-600': mode === 'sell' }" @click="setMode('sell')">Sell</button>
    </div>
    
    <!-- Label and input for USD amount -->
    <label for="usdAmount" class="block text-sm font-medium text-secondarytext" :class="{ 'mt-2': mode === 'sell' }">Amount in USD:</label>
    <input v-model.number="usdAmount" :readonly="mode === 'sell'" type="number" id="usdAmount" @input="updateCryptoAmount"
           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-border rounded-md bg-bg text-primarytext">
    
    <!-- Label and input for Cryptocurrency amount -->
    <label for="cryptoAmount" class="block text-sm font-medium text-secondarytext" :class="{ 'mt-2': mode === 'buy' }">Equivalent Amount:</label>
    <input v-model="cryptoAmount" :readonly="mode === 'buy'" type="text" id="cryptoAmount" @input="updateUsdAmount"
           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-border rounded-md bg-bg text-primarytext">
    
    <!-- Button to Buy/Sell Crypto -->
    <button @click="performTransaction" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
      {{ mode === 'buy' ? 'Buy Crypto' : 'Sell Crypto' }}
    </button>
  </div>
</template>

<script>
import { watchEffect } from 'vue'; // Import watchEffect from Vue
import axios from 'axios';

export default {
  data() {
    return {
      usdAmount: 0,
      cryptoAmount: '',
      mode: 'buy' // Default mode is 'buy'
    };
  },
  props: {
    exchangeRate: {
      type: Number,
      required: true,
    },
    cryptocurrency: {
    type: Object,
    required: true // Or adjust as per your requirement
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
      this.cryptoAmount = this.formattedCryptoAmount;
      this.$emit('cryptoAmountChanged', parseFloat(this.formattedCryptoAmount));
      this.$emit('usdAmountChanged', parseFloat(this.usdAmount));
    },
    updateUsdAmount() {
      if (this.mode === 'sell' && this.cryptoAmount) {
        this.usdAmount = parseFloat(this.cryptoAmount) * this.exchangeRate;
        this.$emit('usdAmountChanged', parseFloat(this.usdAmount));
      }
    },
    setMode(mode) {
      this.mode = mode;
      // Reset input fields when switching modes
      this.usdAmount = '';
      this.cryptoAmount = '';
    },
    async performTransaction() {
      try {
        if (this.mode === 'buy') {
          await this.buyCrypto();
        } else {
          await this.sellCrypto();
        }
      } catch (error) {
        console.error(error); // Handle error
      }
    },
    async buyCrypto() {
      const response = await axios.post('/buy-crypto', {
        cryptocurrency: this.$props.cryptocurrency.id,
        cryptoAmount: parseFloat(this.cryptoAmount),
        usdAmount: parseFloat(this.usdAmount)
      });
      console.log(this.cryptoAmount, this.usdAmount, "Buy done"); // Handle success response
    },
    async sellCrypto() {
      const response = await axios.post('/sell-crypto', {
        cryptocurrency: this.$props.cryptocurrency.id,
        cryptoAmount: parseFloat(this.cryptoAmount),
        usdAmount: parseFloat(this.usdAmount)
      });
      console.log(this.cryptoAmount, this.usdAmount, "Sell done"); // Handle success response
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
