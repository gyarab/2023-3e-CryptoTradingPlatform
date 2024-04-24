<template>
    <img :src="'https://cryptologos.cc/logos/' + cryptocurrency['name'].toLowerCase() + '-' + cryptocurrency['symbol'].toLowerCase() + '-logo.png?v=029'" class=" w-12 inline-flex ">
</template>

<script setup>

import { defineProps } from 'vue';

defineProps({
    cryptocurrency: Object,
});

</script>