<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import LinkCrypto from '@/Components/LinkCrypto.vue';

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
    },

    formatNumber(number) {
  // Convert number to string
  let numberString = number.toString();
  // Insert a space after every three numeric characters from the end
  let formattedString = numberString.replace(/\d{1,3}(?=(\d{3})+(?!\d))/g, '$& ');
  return formattedString;
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
                            {{ formatNumber(dollar['balance']) }}
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
                        <p>Favourite Crypto Currencies:</p> <br>
                        <div class="text-xl mx-" v-for="listedCrypto in favouriteCryptoCurrencies">
                            <div class="p-6 bg-bg mb-5 overflow-hidden shadow-sm shadow-purple-500/50 hover:shadow-purple-500 sm:rounded-lg">
                                <LinkCrypto :cryptocurrency="listedCrypto"/>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 relative">
                        <span>Trades history:</span> 
                        <PrimaryButton @click="toggleVisibility" class="absolute right-0 mx-4">
                            {{ isVisible ? 'HIDE' : 'SHOW' }}
                        </PrimaryButton>
                        <br>
                        <div v-if="isVisible">
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
                                            {{ trade['name'].charAt(0).toUpperCase() + trade['name'].slice(1) }}
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
                                            {{ trade['crypto_amount'] }}
                                        </td>
                                        <td scope="row" class="px-6 py-4 text-red-600 border-border border-b"
                                            v-else>
                                            {{ trade['crypto_amount'] }}
                                        </td>
                                        <td scope="row" class="px-6 py-4 border-border border-b">
                                            {{ trade['usd_amount'] }}
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
