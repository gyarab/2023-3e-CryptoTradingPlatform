<!-- resources/js/components/SearchBar.vue -->

<template>
    <input
      type="text"
      v-model="searchValue"
      @input="updateRoute"
      placeholder="Search Crypto"
      class="p-2 border rounded-md"
    />
  </template>
  
  <script setup>
  import { ref, watch } from 'vue';
  
  const route = useRoute();
  const router = useRouter();
  
  const searchValue = ref(route.params.searchValue || '');
  
  watch(searchValue, (newVal) => {
    router.push({ name: 'Dashboard', params: { searchValue: newVal } });
  });
  </script>
  