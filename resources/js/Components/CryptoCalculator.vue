<template>
<div class="max-w-lg mx-auto mt-6 pb-4 bg-secondarybg shadow-md rounded-lg border-secondarybg border-solid border-2">
  <!-- Buttons for Buy and Sell -->
  <div class="flex justify-between mb-4">
    <button class="px-4 py-2 bg-bg text-primarytext rounded-t-md hover:text-hovertext w-1/2 text-left transition-all" :class="{ 'bg-secondarybg': mode === 'buy' }" @click="setMode('buy')">Buy</button>
    <button class="px-4 py-2 bg-bg text-primarytext rounded-t-md hover:text-hovertext w-1/2 text-right transition" :class="{ 'bg-secondarybg': mode === 'sell' }" @click="setMode('sell')">Sell</button>
  </div>
  <div class="px-4">
  <!-- Label and input for USD amount -->
<label for="usdAmount" class="block text-sm font-medium text-primarytext">Amount in USD:</label>
<input v-model.number="usdAmount" :readonly="mode === 'sell'" type="number" id="usdAmount" @input="updateCryptoAmount"
        :placeholder="mode !== 'sell' ? 'Enter amount in USD' : ''"
        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-border rounded-md bg-bg text-primarytext placeholder:text-secondarytext">

<!-- Label and input for Cryptocurrency amount -->
<label for="cryptoAmount" class="block text-sm font-medium text-primarytext mt-2">Equivalent Amount:</label>
<input v-model="cryptoAmount" :readonly="mode === 'buy'" type="text" id="cryptoAmount" @input="updateUsdAmount"
        :placeholder="mode !== 'buy' ? 'Enter equivalent amount' : ''"
        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-border rounded-md bg-bg text-primarytext placeholder:text-secondarytext">

  
    <!-- Button to Buy/Sell Crypto -->
    <ToggleButton @click="buyCrypto" v-if="mode === 'buy'" :textBefore="'Buy Crypto'" :textAfter="'Bought Successfully'"/>
    <ToggleButton @click="sellCrypto" v-else :textBefore="'Sell Crypto'" :textAfter="'Sold Successfully'"/>
  </div>
</div>
</template>

<script>
import { watchEffect } from 'vue'; // Import watchEffect from Vue
import axios from 'axios';
import ToggleButton from '@/Components/ToggleButton.vue';

export default {
  components: {
    ToggleButton,
  },
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
