<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SearchBar from '@/Components/Searchbar.vue';
import { ref } from 'vue';
import CryptoCalculator from '@/Components/CryptoCalculator.vue';
import LinkCrypto from '@/Components/LinkCrypto.vue'


const { cryptocurrency, message, error_message, url, cryptoDataIn24, cryptoDataIn12, cryptoDataIn1 } = defineProps({
  cryptocurrency: {
    type: Object
  },
  message: {
    type: String
  },
  error_message: {
    type: String
  },
  url: {
    type: String
  },
  cryptoDataIn24: {
    type: Object
  },
  cryptoDataIn12: {
    type: Object
  },
  cryptoDataIn1: {
    type: Object
  },
  balance: {
    type: Array
  },
});

const cryptoAmount = ref(0);

const usdAmount = ref(0);

// ChatGPT(define a function to update cryptoAmount when cryptoAmountCalculated event is emitted)
const updateCryptoAmount = (amount) => {
  cryptoAmount.value = amount;
  console.log(amount);
};

const updateUsdAmount = (amount) => {
  usdAmount.value = amount;
  console.log(amount);
};
</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="md:flex md:items-center md:justify-between">
        <!-- Header for medium and larger screens -->
        <h2 class="font-semibold text-xl text-primarytext leading-tight md:mr-4">
          Cryptonest
        </h2>
        <!-- Search bar section -->
        <SearchBar />
      </div>
    </template>


    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-secondarybg overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg p-2 mb-5">
          <p class="text-primarytext"><span class="font-semibold">Your Balance:</span> <span v-if="balance['balance']">{{
            formatNumber(parseFloat(balance['balance']).toFixed(3)) }}<span class="text-green-500">&dollar;</span></span> 
            <span v-if="!balance['balance']">No money</span>
          </p>
        </div>
        <div class="bg-secondarybg overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg p-2 mb-12">
          <LinkCrypto :cryptocurrency="cryptocurrency" />
        </div>
        <CryptoCalculator :exchangeRate="cryptocurrency.priceUsd" :cryptocurrency="cryptocurrency"
          @cryptoAmountChanged="updateCryptoAmount" @usdAmountChanged="updateUsdAmount" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {
    // ChatGPT() setjná metoda je již ocitována
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