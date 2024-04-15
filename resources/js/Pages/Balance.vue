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
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">
                        <span>Balance:</span> <br>
                        {{ balance }} $
                    </div>
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">Your Crypto Currencies</div>
                    {{ userCryptoCurrencies }}
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">Favourite Crypto Currencies</div>
                    {{ favouriteCryptoCurrencies }}
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">Trades history</div>
                    {{ userTrades }}
                    <div v-for="trade in userTrades">
                        {{ trade['name'] }}
                        {{ trade['crypto_amount'] }}
                        {{ trade['usd_amount'] }}
                        {{ trade['created_at'] }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
