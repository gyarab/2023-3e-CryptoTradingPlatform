<template>
  <a :href="'http://localhost/dashboard/' + cryptocurrency['name'].toLowerCase()">
    <CryptoLogo :cryptocurrency="cryptocurrency" />
    <div class="p-6 text-primarytext inline">{{ cryptocurrency['name'].charAt(0).toUpperCase() +
      cryptocurrency['name'].slice(1) }} <span class="text-gray-300">&#40;{{ cryptocurrency['symbol'] }}&#41;</span>
      <span class="md:ml-5">{{ parseFloat(cryptocurrency['priceUsd']).toFixed(3) }}&#36;</span> <span
        class="text-green-500 md:ml-5"
        v-if="cryptocurrency['changePercent24Hr'] > 0">{{ parseFloat(cryptocurrency['changePercent24Hr']).toFixed(3)
        }}&#37;</span><span class="text-red-500 ml-5"
        v-else>{{ parseFloat(cryptocurrency['changePercent24Hr']).toFixed(3) }}%</span></div>
  </a>
</template>

<script setup>
import CryptoLogo from '@/Components/CryptoLogo.vue'
import { defineProps } from 'vue';

defineProps({
  cryptocurrency: Object,
});

</script>