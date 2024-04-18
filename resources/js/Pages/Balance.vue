<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CryptoCurrency from '@/Components/CryptoCurrency.vue';
import SearchBar from '@/Components/SearchBar.vue';
import CryptoChart from '@/Components/CryptoChart.vue';
import DropdownIntervals from '@/Components/DropdownIntervals.vue';
import { ref } from 'vue';
import { data } from 'autoprefixer';

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
});

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
                            {{ cryptoOwned['name'] }}
                            {{ cryptoOwned['amount'] }}
                        </div>
                    </div>    
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6">
                        <span>Favourite Crypto Currencies:</span> <br>
                        <div class="text-xl mx-" v-for="listedCrypto in favouriteCryptoCurrencies">
                            {{ listedCrypto['name'] }}
                        </div>
                    </div>    
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6">
                        <span>Trades history:</span> <br>
                        <div v-for="trade in userTrades">
                            {{ trade['name'] }}
                            {{ trade['crypto_amount'] }}
                            <span class="text-green-500">$</span>
                            {{ trade['usd_amount'] }}
                            {{ trade['created_at'] }}
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
