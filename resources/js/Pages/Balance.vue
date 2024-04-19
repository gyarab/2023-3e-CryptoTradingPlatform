<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CryptoCurrency from '@/Components/CryptoCurrency.vue';
import SearchBar from '@/Components/SearchBar.vue';
import CryptoChart from '@/Components/CryptoChart.vue';
import DropdownIntervals from '@/Components/DropdownIntervals.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import { data } from 'autoprefixer';
import { timestamp } from '@vueuse/core';

defineProps({
    balance: {
        type: Number
    },
    favouriteCryptoCurrencies: {
        type: Array
    },
    userCryptoCurrencies: {
        type: Array
    },
    userTrades: {
        type: Array
    },
    currenciesInfo: {
        type: Array
    }
});
</script>

<script>
const formatTimestamp = (timestamp) => {
    const date = new Date(timestamp);
    return date.toLocaleString();
};

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
};

</script>

<template>
    <Head title="Balance" />

    <AuthenticatedLayout>
        <template #header>
            <div class="md:flex md:items-center md:justify-between">
                <h2 class="font-semibold text-xl text-primarytext leading-tight md:mr-4">
                Crypto Trading Platform
                </h2>
            </div>
        </template>
        
        <div class="py-12 text-primarytext">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6">
                        <span>Balance:</span> <br>
                        <div v-for="dollar in balance">
                            <span class="text-green-500">$</span>
                            {{ dollar['balance'] }} 
                        </div>
                    </div>
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6">
                        <span>Your Crypto Currencies:</span> <br>
                        <div class="text-xl" v-for="cryptoOwned in userCryptoCurrencies">
                            {{ cryptoOwned['name'].charAt(0).toUpperCase() + cryptoOwned['name'].slice(1) }}
                            {{ cryptoOwned['amount'] }}<span class="text-secondarytext">{{ cryptoOwned['symbol'] }}</span>
                        </div>
                    </div>    
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6">
                        <span>Favourite Crypto Currencies:</span> <br>
                        <div class="text-xl my-4" v-for="listedCrypto in favouriteCryptoCurrencies">
                            <img class="w-12 inline" :src="'https://cryptologos.cc/logos/' + listedCrypto['name'].toLowerCase() + '-' + listedCrypto['symbol'].toLowerCase() + '-logo.png?v=029'">
                            {{ listedCrypto['name'].charAt(0).toUpperCase() + listedCrypto['name'].slice(1) }}
                        </div>
                    </div>    
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 relative">
                        <span>Trades history:</span> 
                        <PrimaryButton @click="toggleVisibility" class="absolute right-0 mx-4">
                            SHOW
                        </PrimaryButton>
                        <br>
                        <div v-if="isVisible">
                            <div v-for="trade in userTrades">
                                {{ trade['name'].charAt(0).toUpperCase()+trade['name'].slice(1) }}
                                {{ trade['crypto_amount'] }}<span class="text-secondarytext">{{ trade['symbol'] }}</span>
                                <span class="text-green-500"> $</span>{{ trade['usd_amount'] }}
                            
                                {{ formatTimestamp(trade['created_at']) }}
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
