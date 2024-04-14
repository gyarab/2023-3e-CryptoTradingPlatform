<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SearchBar from '@/Components/SearchBar.vue';
import { ref } from 'vue';
import CryptoCalculator from '@/Components/CryptoCalculator.vue'


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
});

const cryptoAmount = ref(0);

const usdAmount = ref(0);

// Define a function to update cryptoAmount when cryptoAmountCalculated event is emitted
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
                Crypto Trading Platform
                </h2>
                <!-- Search bar section -->
                <SearchBar />
            </div>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-secondarybg overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg p-2">
                    <img :src="'https://cryptologos.cc/logos/' + cryptocurrency['id'] + '-' + cryptocurrency['symbol'].toLowerCase() + '-logo.png?v=029'" class=" w-12 inline-flex ">
                    <div class="p-6 text-primarytext inline">{{ cryptocurrency['name'] }}</div>

                </div>
                <div class="bg-bg text-primarytext overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg mt-5">
                </div>
                <CryptoCalculator :exchangeRate="cryptocurrency.priceUsd" :cryptocurrency="cryptocurrency" @cryptoAmountChanged="updateCryptoAmount"  @usdAmountChanged="updateUsdAmount"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>