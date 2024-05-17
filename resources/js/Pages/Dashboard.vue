<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CryptoCurrency from '@/Components/CryptoCurrency.vue';
import SearchBar from '@/Components/Searchbar.vue';
import CryptoChart from '@/Components/CryptoChart.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps({
  cryptocurrency: {
    type: Object,
  },
  error_message: {
    type: String
  },
  url: {
    type: String
  },
  cryptoDataIn1M: {
    type: Object
  },
  cryptoDataIn1W: {
    type: Object
  },
  cryptoDataIn6: {
    type: Object
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
  favourite_cryptocurrency: {
    type: Boolean
  },
  ListOfCurrencies: {
    type: Object
  }
});
</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="md:flex md:items-center md:justify-between bg-bg text-primarytext">
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
        <div v-if="url == 'dashboard'" class="bg-bg mb-4 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
          <div class="p-6 text-primarytext bg-secondarybg">You're logged in!</div>
        </div>
        <span v-if="ListOfCurrencies">
          <div v-for="currency in ListOfCurrencies"
            class="bg-bg mb-4 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
            <div class="p-6 text-primarytext bg-secondarybg">
              <CryptoCurrency :cryptocurrencyName="currency['values']['data']['name']"
                :shortcut="currency['values']['data']['symbol']" :priceUsd="currency['values']['data']['priceUsd']"
                :supply="currency['values']['data']['supply']" :maxSupply="currency['values']['data']['maxSupply']"
                :volumeUsd24Hr="currency['values']['data']['volumeUsd24Hr']"
                :changePercent24Hr="currency['values']['data']['changePercent24Hr']"
                :vwap24Hr="currency['values']['data']['vwap24Hr']"
                :currencyImg="'https://cryptologos.cc/logos/' + currency['values']['data']['id'] + '-' + currency['values']['data']['symbol'].toLowerCase() + '-logo.png?v=029'"
                :addedToList=true />

              <PrimaryButton @click="toggleVisibility(currency)" class="mx-4">
                {{ currency.showChart ? 'HIDE Chart' : 'SHOW Chart' }}
              </PrimaryButton>

              <CryptoChart v-if="currency.showChart" :dataM="currency['dataM']" :dataW="currency['dataW']"
                :dataIn24="currency['data24']" :dataIn12="currency['data12']" :dataIn6="currency['data6']"
                :dataIn1="currency['data1']" :name="currency['values']['data']['name']" />
            </div>
          </div>
        </span>
        <div v-else class="bg-bg text-primarytext overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg mt-5">
          <span class="p-6" v-if="error_message">{{ error_message }}</span>
          <span v-else-if="url">
            <CryptoCurrency :cryptocurrencyName="cryptocurrency['name']" :shortcut="cryptocurrency['symbol']"
              :priceUsd="cryptocurrency['priceUsd']" :supply="cryptocurrency['supply']"
              :maxSupply="cryptocurrency['maxSupply']" :volumeUsd24Hr="cryptocurrency['volumeUsd24Hr']"
              :changePercent24Hr="cryptocurrency['changePercent24Hr']" :vwap24Hr="cryptocurrency['vwap24Hr']"
              :currencyImg="'https://cryptologos.cc/logos/' + cryptocurrency['id'] + '-' + cryptocurrency['symbol'].toLowerCase() + '-logo.png?v=029'"
              :addedToList=favourite_cryptocurrency />
            <CryptoChart :dataM="cryptoDataIn1M" :dataW="cryptoDataIn1W" :dataIn24="cryptoDataIn24"
              :dataIn12="cryptoDataIn12" :dataIn6="cryptoDataIn6" :dataIn1="cryptoDataIn1"
              :name="cryptocurrency['name']" />
          </span>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>

export default {
  data() {
    return {
      showChart: false
    };
  },
  methods: {
    toggleVisibility(currency) {
      currency.showChart = !currency.showChart;
    }
  }
};

</script>
