<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import LinkCrypto from '@/Components/LinkCrypto.vue';
import CryptoLogo from '@/Components/CryptoLogo.vue'
import { parse } from 'vue/compiler-sfc';

defineProps({
    balance: {
        type: Array
    },
    wealth: {
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
    },

    formatNumber(number) {
  // Convert number to string
  let numberString = number.toString();
  // Remove trailing zeros and decimal point if all decimal places are zeros
  let formattedString = numberString.replace(/(\.[0-9]*[1-9])0+$|\.0*$/, '$1');
  // Insert a space after every three numeric characters from the end
  formattedString = formattedString.replace(/\d{1,3}(?=(\d{3})+(?!\d))/g, '$& ');
  return formattedString;
}
,
    capitalizeFirstLetter(name){
        return name.charAt(0).toUpperCase() + name.slice(1);
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
                        <span class="text-xl font-semibold">Balance:</span> <!--font-semibold text-xl bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-pink-500-->
                        <p class="mt-2">
                            Your Wallet: {{ formatNumber(parseFloat((balance['balance'])).toFixed(3)) }} 
                            <span class="text-green-500">&dollar;</span></p>
                        <p class="mt-2">
                            Your money in Crypto: {{ formatNumber(parseFloat((wealth)).toFixed(3)) }} 
                            <span class="text-green-500">&dollar;</span>
                        </p>
                        <p class="mt-2">
                            Your total wealth:
                            {{ (parseFloat(parseFloat(wealth).toFixed(3)) + parseFloat(parseFloat(balance['balance']).toFixed(3))).toFixed(3) }}
                            <span class="text-green-500">&dollar;</span>
                        </p>
                    </div>
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6">
                        <span class="text-xl font-semibold">Your Crypto Currencies:</span> <br>
                        <div class="text-xl mt-4" v-if="userCryptoCurrencies != ''" v-for="cryptoOwned in userCryptoCurrencies">
                            {{ capitalizeFirstLetter(cryptoOwned['name']) }}
                            <CryptoLogo class="mr-3 w-7" :cryptocurrency="cryptoOwned" />
                            {{ formatNumber(cryptoOwned['amount']) }}
                            <span class="text-secondarytext">{{ cryptoOwned['symbol'] }}</span>
                            <span class="ml-3 mr-1">=</span>
                            {{ formatNumber(cryptoOwned['amount'] * cryptoOwned['priceUsd']) }}
                            <span class="text-green-500" >&dollar;</span>
                        </div>
                        <p v-else>
                            <span class="mt-5 text-red-500">You do not own any Crypto Currencies</span>
                        </p>
                    </div>    
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-xl font-semiboldl">Favourite Crypto Currencies:</p> <br>
                        <div class="text-xl mx-" v-for="listedCrypto in favouriteCryptoCurrencies">
                            <div class="p-6 bg-bg mb-5 overflow-hidden shadow-sm shadow-purple-500/50 hover:shadow-purple-500 sm:rounded-lg">
                                <LinkCrypto :cryptocurrency="listedCrypto"/>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 relative">
                        <span class="text-xl font-semibold">Trades history:</span> 
                        <PrimaryButton @click="toggleVisibility" class="absolute right-0 mx-4">
                            {{ isVisible ? 'HIDE' : 'SHOW' }}
                        </PrimaryButton>
                        <br> 
                        <p class="mt-5 text-red-500" v-if="userTrades == '' & isVisible">You have not made any Trades yet</p>
                        <div v-if="isVisible & userTrades != ''">
                            <table class="border-none min-w-full text-left text-sm font-light rounded-lg bg-bg text-primarytext">
                                <thead class="border-none border-b-2 border-border font-medium text-xs uppercase">
                                    <th scope="col" class="px-6 py-3 border-border border-b-2">
                                        CryptoCurrency
                                    </th>
                                    <th scope="col" class="px-6 py-3 border-border border-b-2 hidden sm:table-cell">
                                        Side
                                    </th>
                                    <th scope="col" class="px-6 py-3 border-border border-b-2">
                                        Quantity
                                    </th>
                                    <th scope="col" class="px-6 py-3 border-border border-b-2">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 border-border border-b-2 hidden sm:table-cell">
                                        Update
                                    </th>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="trade in userTrades">
                                        <td scope="row" class="px-6 py-4 border-border border-b">
                                            {{ capitalizeFirstLetter(trade['name']) }}
                                        </td>
                                        <td scope="row" class="px-6 py-4 text-green-500 border-border border-b hidden sm:table-cell"
                                            v-if="trade['bought_crypto']">
                                            Buy
                                        </td>
                                        <td scope="row" class="px-6 py-4 text-red-600 border-border border-b hidden sm:table-cell"
                                            v-else>
                                            Sell
                                        </td>
                                        <td scope="row" class="px-6 py-4 text-green-500 border-border border-b"
                                            v-if="trade['bought_crypto']">
                                            {{ formatNumber(trade['crypto_amount']) }}
                                        </td>
                                        <td scope="row" class="px-6 py-4 text-red-600 border-border border-b"
                                            v-else>
                                            {{ formatNumber(trade['crypto_amount']) }}
                                        </td>
                                        <td scope="row" class="px-6 py-4 border-border border-b">
                                            {{ formatNumber(trade['usd_amount']) }}
                                        </td>
                                        <td scope= "row" class="px-6 py-4 border-border border-b hidden sm:table-cell">
                                            {{ formatTimestamp(trade['created_at']) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
