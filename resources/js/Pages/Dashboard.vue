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
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
      <div class="md:flex md:items-center md:justify-between">
        <!-- Header for medium and larger screens -->
        <h2 class="font-semibold text-xl text-primarytext leading-tight md:mr-4">
          Crypto Trading Platform
        </h2>
        <!-- Search bar section -->
        <SearchBar />
      </div>
    </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-bg overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">You're logged in!</div>
                </div>
                <div class="bg-bg text-primarytext overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg mt-5">
                    <span class="p-6" v-if="error_message">{{ error_message }}</span>
                    <span v-else-if="url">
                        
                        <CryptoCurrency 
                            :name="cryptocurrency['name']"
                            :shortcut="cryptocurrency['symbol']" 
                            :priceUsd="cryptocurrency['priceUsd']"
                            :supply="cryptocurrency['supply']"
                            :maxSupply="cryptocurrency['maxSupply']"
                            :volumeUsd24Hr="cryptocurrency['volumeUsd24Hr']"
                            :changePercent24Hr="cryptocurrency['changePercent24Hr']"
                            :vwap24Hr="cryptocurrency['vwap24Hr']"
                            :currencyImg="'https://cryptologos.cc/logos/' + cryptocurrency['id'] + '-' + cryptocurrency['symbol'].toLowerCase() + '-logo.png?v=029'"
                            />
                            <CryptoChart 
                                :dataIn24="cryptoDataIn24"
                                :dataIn12="cryptoDataIn12"
                                :dataIn1="cryptoDataIn1"
                                :name="cryptocurrency['name']"
                            />
                    </span>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
