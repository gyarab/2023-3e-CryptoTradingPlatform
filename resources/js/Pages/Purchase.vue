<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CryptoCurrency from '@/Components/CryptoCurrency.vue';
import SearchBar from '@/Components/SearchBar.vue';
import CryptoChart from '@/Components/CryptoChart.vue';
import DropdownIntervals from '@/Components/DropdownIntervals.vue';
import { ref } from 'vue';
import { data } from 'autoprefixer';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import axios from 'axios';
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

const buyCrypto = async (amount) => {
    try {
        const response = await axios.post('/buy-crypto', { cryptocurrency: cryptocurrency.id, amount });
        console.log("DONE!"); // Handle success response
    } catch (error) {
        console.error(error); // Handle error
    }
};

const cryptoAmount = ref(0);

// Define a function to update cryptoAmount when cryptoAmountCalculated event is emitted
const updateCryptoAmount = (amount) => {
  cryptoAmount.value = amount;
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
                <div class="bg-bg overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">{{ cryptocurrency['name'] }} {{ cryptocurrency['priceUsd'] }}</div>

                </div>
                <div class="bg-bg text-primarytext overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg mt-5">
                    <button @click="buyCrypto(cryptoAmount)">Buy Crypto</button>
                </div>
                <CryptoCalculator :exchangeRate="cryptocurrency['priceUsd']" @cryptoAmountChanged="updateCryptoAmount"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>