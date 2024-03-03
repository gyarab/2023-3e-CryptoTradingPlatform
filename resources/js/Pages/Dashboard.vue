<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CryptoCurrency from '@/Components/CryptoCurrency.vue';
import { ref } from 'vue';

const searchValue = ref('');

const redirectToUserInput = () => {
  const targetUrl = searchValue.value ? `/dashboard/${searchValue.value}` : '/dashboard';
  console.log('Redirecting to:', targetUrl);
  window.location.href = targetUrl;
};

defineProps({
    cryptocurrency: {
        type: Object,
    },
    error_message: {
        type: String
    },
    url: {
        type: String
    }
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
        <div class="p-6 w-full md:w-auto" v-if="!error_message">
          <form @submit.prevent="redirectToUserInput">
            <div class="flex items-center">
              <input
                type="text"
                v-model="searchValue"
                placeholder="Search for Crypto..."
                class="p-4 border rounded-md mr-2 w-full"
              />
              <button type="submit" class="p-4 bg-primarytext text-white rounded-md">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  class="h-6 w-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                  ></path>
                </svg>
              </button>
            </div>
          </form>
        </div>
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
                    </span>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
