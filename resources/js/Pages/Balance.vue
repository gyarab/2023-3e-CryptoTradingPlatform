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
    cryptocurrency: {
        type: Object,
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
                        <span>Balance</span>
                        <p>100 <span class="text-green-500">$</span></p>
                    </div>
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">Your Crypto Currencies</div>
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">Favourite Crypto Currencies</div>
                </div>
                <div class="bg-bg mb-5 overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">Trades history</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
